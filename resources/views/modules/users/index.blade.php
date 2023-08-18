@extends('layouts/layoutMaster')
@section('title', 'List Users')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('user') }}
@endsection

@section('content')
    <div class="row g-4">
        @if(\Auth::user()->id_user_group != \App\Models\UserGroup::ADMIN_COMPANY )
            @if($userGroup)
                @foreach($userGroup as $group)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-normal mb-2">Total 4 users</h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-end mt-1">
                                    <div class="role-heading">
                                        <h4 class="mb-1">{{ucwords(strtolower($group->name))}}</h4>
                                        <a href="javascript:" data-bs-toggle="modal"
                                           data-bs-target="#addRoleModal_{{$group->id_user_group}}"
                                           class="role-edit-modal"><span>Edit Role</span></a>
                                    </div>
                                    <a href="javascript:void(0);" class="text-muted"><i
                                            class="ti ti-copy ti-md"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($permission->has_edit)
                        <!-- START MODAL EDIT {{$group->name}}-->
                        <div class="modal fade" id="addRoleModal_{{$group->id_user_group}}" tabindex="-1"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                                <div class="modal-content p-3 p-md-5">
                                    <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <h3 class="role-title mb-2">Edit Role {{$group->name}}</h3>
                                            <p class="text-muted">Set role permissions</p>
                                        </div>
                                        <!-- Add role form -->
                                        <form id="addRoleForm_{{$group->id_user_group}}"
                                              method="POST"
                                              action="{{route('management-user.updateUserGroup', ['id'=> $group->id_user_group])}}"
                                              class="row g-3">
                                            @csrf
                                            <div class="col-12">
                                                <h5>Role Permissions</h5>
                                                <!-- Permission table -->
                                                <div class="table-responsive">
                                                    <table class="table table-flush-spacing">
                                                        <tbody>
                                                        <tr>
                                                            <td class="text-nowrap fw-semibold">Administrator
                                                                <i
                                                                    class="ti ti-info-circle" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="Allows a full access to the system"></i></td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input select-all"
                                                                           type="checkbox"
                                                                           data-class="select_{{$group->id_user_group}}"/>
                                                                    <label class="form-check-label" for="selectAll">
                                                                        Select All
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @foreach($group->privilages as $privilege)
                                                            <tr>
                                                                <td class="text-nowrap fw-semibold">{{$privilege->menu->name}}</td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <input type="hidden"
                                                                               value="{{$privilege->id_user_group_privilege}}"
                                                                               name="privilege[{{$privilege->id_user_group_privilege}}][id_user_group_privilege]">
                                                                        <div class="form-check me-3 me-lg-5">
                                                                            <input
                                                                                class="form-check-input select_{{$group->id_user_group}}"
                                                                                type="checkbox"
                                                                                value="1"
                                                                                name="privilege[{{$privilege->id_user_group_privilege}}][has_view]"
                                                                                @if($privilege->has_view) checked @endif
                                                                                id="has_view_{{$privilege->id_user_group_privilege}}"
                                                                            />
                                                                            <label class="form-check-label"
                                                                                   for="has_view_{{$privilege->id_user_group_privilege}}">
                                                                                Read
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check me-3 me-lg-5">
                                                                            <input
                                                                                class="form-check-input select_{{$group->id_user_group}}"
                                                                                type="checkbox"
                                                                                value="1"
                                                                                name="privilege[{{$privilege->id_user_group_privilege}}][has_edit]"
                                                                                @if($privilege->has_edit) checked @endif
                                                                                id="has_edit_{{$privilege->id_user_group_privilege}}"
                                                                            />
                                                                            <label class="form-check-label"
                                                                                   for="has_edit_{{$privilege->id_user_group_privilege}}">
                                                                                Write
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input
                                                                                class="form-check-input select_{{$group->id_user_group}}"
                                                                                type="checkbox"
                                                                                value="1"
                                                                                name="privilege[{{$privilege->id_user_group_privilege}}][has_create]"
                                                                                @if($privilege->has_create) checked
                                                                                @endif
                                                                                id="has_create_{{$privilege->id_user_group_privilege}}"
                                                                            />
                                                                            <label class="form-check-label"
                                                                                   for="has_create_{{$privilege->id_user_group_privilege}}">
                                                                                Create
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Permission table -->
                                            </div>
                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit
                                                </button>
                                                <button type="reset" class="btn btn-label-secondary"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close">Cancel
                                                </button>
                                            </div>
                                        </form>
                                        <!--/ Add role form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL EDIT {{$group->name}} -->
                    @endif

                @endforeach
            @endif
        @endif
        @if($permission->has_create)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-3">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}"
                                     class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83">
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <div class="">
                                    @if(Auth::user()->id_user_group == \App\Models\UserGroup::ADMINISTRATOR)
                                        <a href="{{route('management-user.activity')}}"
                                           class="btn btn-secondary mb-2 text-nowrap me-2">Log User Activity</a>
                                    @endif
                                    <button data-bs-target="#offcanvasAddUser" data-bs-toggle="offcanvas"
                                            class="btn btn-primary mb-2 text-nowrap add-new-role">Add New User
                                    </button>
                                </div>
                                <p class="mb-0 mt-1">Add user, if it does not exist</p>
                                <!-- Modal to add new user starts-->
                                <!-- Modal to add new user Ends-->
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
                                     aria-labelledby="offcanvasAddUserLabel">
                                    <div class="offcanvas-header">
                                        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                                        <form class="add-new-user" id="form-new-user" onsubmit="return false">
                                            <div class=" flex-grow-1">
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-icon-default-fullname">Full
                                                        Name</label>
                                                    <input type="text" class="form-control dt-full-name"
                                                           id="user-fullname" placeholder="Full Name"
                                                           name="user-fullname"/>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-icon-default-uname">NPK</label>
                                                    <input type="text" id="user-npk" class="form-control dt-uname"
                                                           placeholder="NPK"
                                                           aria-describedby="basic-icon-default-uname2"
                                                           name="user-npk"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                           for="basic-icon-default-email">Email</label>
                                                    <input type="text" id="user-email" class="form-control dt-email"
                                                           placeholder="john.doe@example.com" name="user-email"/>
                                                    <small class="form-text text-muted"> You can use letters, numbers &
                                                        periods </small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="mobile">Phone Number</label>
                                                    <input id="mobile" type="number" class="form-control"
                                                           placeholder="Phone Number"
                                                           name="user-phone"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="user-group">User Group</label>
                                                    <select id="user-group" name="user-group"
                                                            class="form-control select2"
                                                            data-placeholder="Select User Group">
                                                        <option></option>
                                                        @foreach($userGroup as $ug)
                                                            <option
                                                                value="{{$ug->id_user_group}}">{{$ug->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <h5 class="modal-title mt-2 mb-1" id="exampleModalLabel">Account
                                                    Settings</h5>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                           for="basic-icon-default-uname">Username</label>
                                                    <input type="text" id="user-name" class="form-control dt-uname"
                                                           placeholder="username" name="user-name"/>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label"
                                                           for="basic-default-password">Password</label>
                                                    <input type="password" id="basic-default-password"
                                                           name="default-password"
                                                           class="form-control"
                                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="default-password-confirmation">Confirm
                                                        Password</label>
                                                    <input type="password" id="default-password-confirmation"
                                                           name="default-password_confirmation"
                                                           class="form-control"
                                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                                </div>
                                                <div class="mb-3" id="container-company">
                                                    <label class="form-label" for="user-group">Company</label>
                                                    <select id="user-company" name="user-company"
                                                            class="form-control select2"
                                                            data-placeholder="Select Company">
                                                        <option></option>
                                                        @foreach($company as $c)
                                                            <option
                                                                value="{{$c->id_company}}">{{$c->company_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary mr-1 data-submit"
                                                        id="submit-new-user">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary"
                                                        data-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-12">
            <!-- Role Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-users table border-top">
                        <thead>
                        <tr>
                            <th></th>
                            <th>User</th>
                            <th>NPK</th>
                            <th>Role</th>
                            <th>Company</th>
                            <th>Area</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!--/ Role Table -->
        </div>
    </div>

@endsection

@section('vendor-script')
    <!-- BEGIN: Page Vendor JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js" nonce="{{csp_nonce()}}"></script>

    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/PasswordStrength.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>

    <!-- END: Page Vendor JS-->
@endsection

@section('page-script')
    <script src="{{asset('assets/js/pages/app-access-roles.js')}}"></script>

    <script nonce="{{ csp_nonce() }}">
        var newUserForm = $('.add-new-user'),
            statusObj = {
                1: {
                    title: 'Pending',
                    class: 'badge-light-warning'
                },
                2: {
                    title: 'Active',
                    class: 'badge-light-success'
                },
                3: {
                    title: 'Inactive',
                    class: 'badge-light-secondary'
                }
            };
        var offcanvasAddUser = document.getElementById('offcanvasAddUser')
        let newUserSidebar = bootstrap.Offcanvas.getInstance(offcanvasAddUser);

        assetPath = "{{url('/')}}/";

        // Form Validation
        if (newUserForm.length) {
            const formNewUser = document.getElementById('form-new-user')

            const fv = FormValidation.formValidation(formNewUser, {
                fields: {
                    'user-fullname': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter fullname '
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9 ]+$/,
                                message: 'The name can only consist of alphabetical, number and space'
                            }
                        },

                    },
                    'user-email': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter your email'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    'user-phone': {

                        validators: {
                            notEmpty: {
                                message: 'Please enter phone number '
                            },
                            stringLength: {
                                min: 10,
                                max: 15,
                                message: 'The name must be more than 10 and less than 15 characters long'
                            },
                            regexp: {
                                regexp: /^[0-9 ]+$/,
                                message: 'The name can only consist of number'
                            }
                        }
                    },
                    'default-password': {
                        validators: {
                            notEmpty: {
                                message: 'Please enter your password'
                            },
                            stringLength: {
                                min: 6,
                                message: 'The name must be more than 6 and less than 30 characters long'
                            },
                        },
                    },
                    'default-password-confirmation': {
                        validators: {
                            notEmpty: {
                                message: 'Please confirm password'
                            },
                            identical: {
                                compare: function () {
                                    return formNewUser.querySelector('[name="basic-default-password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        // Use this for enabling/changing valid/invalid class
                        eleValidClass: '',
                        rowSelector: function (field, ele) {
                            // field is the field name & ele is the field element
                            return '.mb-3';
                        }
                    }),
                    passwordStrength: new FormValidation.plugins.PasswordStrength({
                        field: 'default-password',
                        message: 'The password is weak',
                        minimalScore: 6,
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // Submit the form when all fields are valid
                    // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                }
            }).on('core.form.valid', function () {
                var dataForm = convertFormToJSON($("#form-new-user"))
                $.ajax({
                    type: "POST",
                    url: "{{route('management-user.store')}}",
                    data: dataForm,
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Update Success!',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then(function () {
                            var offcanvasAddUser = document.getElementById('offcanvasAddUser')
                            let newUserSidebar = bootstrap.Offcanvas.getInstance(offcanvasAddUser);
                            newUserSidebar.hide()
                            dtUserTable.DataTable().ajax.reload()
                        });
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                        Swal.fire('Error', error, 'error')
                    }
                });
            });

            newUserForm.on('submit', function (e) {
                var isValid = newUserForm.valid();
                console.log(isValid)
                e.preventDefault();
                if (isValid) {

                }
            });
        }
        $('.select2').each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            }).change(function () {
            });
        });

        $('#user-group').on('select2:select', function (e) {
            var data = e.params.data;
            if (jQuery.inArray(data.id, ['3', '4', '5']) !== -1) {
                $("#container-company").show()
            } else {
                $("#container-company").hide()
            }
        });
        $("#container-company").hide()

        offcanvasAddUser.addEventListener('hidden.bs.offcanvas', function () {
            $("#form-new-user").trigger("reset");
            $("#user-group").val("").trigger('change');
            $("#user-company").val("").trigger('change');
        })

        const selectAll = $('.select-all');
        $.each(selectAll, function (e, l) {
            const childSelectClass = $(l).data('class');
            $(l).on('click', e => {
                if (e.currentTarget.checked) {
                    document.querySelectorAll('.' + childSelectClass).forEach(c => (c.checked = 1));
                } else {
                    document.querySelectorAll('.' + childSelectClass).forEach(c => (c.checked = 0));
                }
            });
        });

        function deleteUser(id_user) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    // delete the data
                    $.ajax({
                        type: 'DELETE',
                        url: "".concat(baseUrl, "management-user/delete/").concat(id_user),
                        success: function success() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The user has been deleted!',
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            }).then(function () {
                                window.location.href = '{{route('management-user.index')}}'
                            });
                        },
                        error: function error(_error) {
                            console.log(_error);
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'The User is not deleted!',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                }
            });
        }

    </script>
@endsection
