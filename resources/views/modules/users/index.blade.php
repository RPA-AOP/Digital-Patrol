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
  <!-- users list start -->
  <section class="app-user-list">
    <!-- users filter start -->
    <div class="card mb-2">
      <h5 class="card-header">Search Filter</h5>
      <div class="d-flex justify-content-between align-items-center mx-50 row pt-0 pb-2 px-2">
        <div class="col-md-6 user_role">
          <select id="UnitKerja" class="form-control select2 text-capitalize mb-md-0 mb-2">
            <option value=""> Select Perusahaan</option>
          </select>
        </div>
        <div class="col-md-6 user_plan">
          <select id="UserGroup" class="form-control select2 text-capitalize mb-md-0 mb-2">
            <option value=""> Select Tipe User</option>
          </select>
        </div>
      </div>
    </div>
    <!-- users filter end -->
    <!-- list section start -->
    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <table class="user-list-table table">
          <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Tipe User</th>
            <th>Action</th>
          </tr>
          </thead>
        </table>
      </div>
      @if($permission->has_create)
        <!-- Modal to add new user starts-->
        <!-- Modal to add new user Ends-->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
             aria-labelledby="offcanvasAddUserLabel">
          <div class="offcanvas-header">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
            <form class="add-new-user" id="form-new-user" onsubmit="return false">
              <div class=" flex-grow-1">
                <div class="mb-3">
                  <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                  <input type="text" class="form-control dt-full-name"
                         id="user-fullname" placeholder="Full Name" name="user-fullname"/>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="basic-icon-default-uname">NPK</label>
                  <input type="text" id="user-npk" class="form-control dt-uname"
                         placeholder="NPK"
                         aria-describedby="basic-icon-default-uname2" name="user-npk"/>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="basic-icon-default-email">Email</label>
                  <input type="text" id="user-email" class="form-control dt-email"
                         placeholder="john.doe@example.com" name="user-email"/>
                  <small class="form-text text-muted"> You can use letters, numbers & periods </small>
                </div>
                <div class="mb-3">
                  <label for="mobile">Phone Number</label>
                  <input id="mobile" type="text" class="form-control" placeholder="Phone Number"
                         name="user-phone"/>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="user-group">User Group</label>
                  <select id="user-group" name="user-group" class="form-control select2"
                          data-placeholder="Select User Group">
                    <option></option>
                    @foreach($userGroup as $ug)
                      <option value="{{$ug->id_user_group}}">{{$ug->name}}</option>
                    @endforeach
                  </select>
                </div>

                <h5 class="modal-title mt-2 mb-1" id="exampleModalLabel">Account Settings</h5>
                <div class="mb-3">
                  <label class="form-label" for="basic-icon-default-uname">Username</label>
                  <input type="text" id="user-name" class="form-control dt-uname"
                         placeholder="username" name="user-name"/>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="basic-default-password">Password</label>
                  <input type="password" id="basic-default-password" name="default-password" class="form-control"
                         placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="default-password-confirmation">Confirm Password</label>
                  <input type="password" id="default-password-confirmation" name="default-password_confirmation"
                         class="form-control"
                         placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                </div>
                <div class="mb-3" id="container-company">
                  <label class="form-label" for="user-group">Company</label>
                  <select id="user-company" name="user-company" class="form-control select2"
                          data-placeholder="Select Company">
                    <option></option>
                    @foreach($company as $c)
                      <option value="{{$c->id_company}}">{{$c->company_name}}</option>
                    @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-primary mr-1 data-submit" id="submit-new-user">Submit</button>
                <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel
                </button>
              </div>
            </form>
          </div>
        </div>

      @endif
    </div>
    <!-- list section end -->
  </section>
  <!-- users list ends -->
@endsection

@section('vendor-script')
  <!-- BEGIN: Page Vendor JS-->
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>


  <!-- END: Page Vendor JS-->
@endsection

@section('page-script')

  <script>
    var dtUserTable = $('.user-list-table'),
      newUserForm = $('.add-new-user'),
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

    // Users List datatable
    if (dtUserTable.length) {
      dtUserTable.DataTable({
        ajax: "{{route('management-user.list')}}", // JSON file to add data
        columns: [
          // columns according to JSON
          {
            data: 'nama',
            render: function (item, data, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            data: 'nama',
          },
          {
            data: 'username',
          },
          {
            data: 'user_group.name',
            render: function (data) {
              return `<span class="badge rounded-pill bg-primary">${data}</span>`
            }
          },
          {
            data: 'id_user',
            name: 'id_user',
            sortable: false,
            searchable: false,
            render: function (data) {
              return (
                '<div class="d-flex align-items-center">' +
                '<a href="{{ url('management-user/edit/') }}/' + data + '" class="text-body"><i class="ti ti-edit ti-sm me-2"></i></a>' +
                '<a  href="javascript:;" onclick="deleteUser(' + data + ')" class="text-body delete-record"><i class="ti ti-trash ti-sm mx-2"></i></button>' +
                '<a href="javascript:;" class="text-body dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm mx-1"></i></a>' +
                '<div class="dropdown-menu dropdown-menu-end m-0">' +
                '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
                '</div>' +
                '</div>'
              );
            }
          },

        ],
        order: [
          [2, 'desc']
        ],
        dom: '<"d-flex justify-content-between align-items-center header-actions m-1 row mt-75"' +
          '<"col-lg-12 col-xl-6" l>' +
          '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
          '>t' +
          '<"d-flex justify-content-between mx-2 row mb-1"' +
          '<"col-sm-12 col-md-6"i>' +
          '<"col-sm-12 col-md-6"p>' +
          '>',
        language: {
          sLengthMenu: 'Show _MENU_',
          search: '',
          searchPlaceholder: 'Search..',
          paginate: {
            // remove previous & next text from pagination
            previous: '&nbsp;',
            next: '&nbsp;'
          }
        },
        @if($permission -> has_create)
        // Buttons with Dropdown
        buttons: [{
          text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>Tambah User',
          className: 'add-new btn btn-sm btn-primary ms-2',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
        ],
        @endif
        // For responsive popup
        responsive: {
          details: {
            display: $.fn.dataTable.Responsive.display.modal({
              header: function (row) {
                var data = row.data();
                return 'Details of ' + data['full_name'];
              }
            }),
            type: 'column',
            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
              tableClass: 'table',
              columnDefs: [{
                targets: 2,
                visible: false
              },
                {
                  targets: 3,
                  visible: false
                }
              ]
            })
          }
        },
        initComplete: function () {
          // Adding role filter once table initialized
          this.api()
            .columns(3)
            .every(function () {
              var column = this;
              var select = $('#UserGroup').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

              column
                .data()
                .unique()
                .sort()
                .each(function (d, j) {
                  select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                });
            });
          this.api()
            .columns(4)
            .every(function () {
              var column = this;
              var select = $('#UnitKerja').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

              column
                .data()
                .unique()
                .sort()
                .each(function (d, j) {
                  select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                });
            });
        }
      });
    }

    // Form Validation
    if (newUserForm.length) {
      const formNewUser = document.getElementById('form-new-user')

      const fv = FormValidation.formValidation(formNewUser, {
        fields: {
          'user-fullname': {
            validators: {
              notEmpty: {
                message: 'Please enter fullname '
              }
            }
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
              }
            }
          },
          'basic-default-password': {
            validators: {
              notEmpty: {
                message: 'Please enter your password'
              }
            }
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
      if (jQuery.inArray(data.id, ['3', '4']) !== -1) {
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

  </script>
@endsection
