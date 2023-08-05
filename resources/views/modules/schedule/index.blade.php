@extends('layouts/layoutMaster')
@section('title', 'Company Configuration List')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection

@section('vendor-style')
    <script nonce="{{ csp_nonce() }}"></script>

  </style>
@endsection
@section('content')
  <!-- list start -->
  <section id="responsive-datatable">
    <div class="card">
      <div class="card-header">
        <div class="head-label mb-0">
          <h5>Configuation List</h5>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive pt-0">
          <table class="datatables-ajax table dataTable" id="table-company">
          </table>
        </div>
      </div>
    </div>
  </section>
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
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

  <!-- END: Page Vendor JS-->
@endsection

@section('page-script')

  <script nonce="{{ csp_nonce() }}">
    $('#table-company').DataTable({
      ajax: "{{route('master.company.list')}}",
      responsive: false,
      columns: [
        {
          data: 'id_company',
          render: function (item, data, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          data: 'company_name',
          name: 'company_name',
          title: 'Nama Perusahaan'
        },
        {
          data: 'proses_utama',
          name: 'proses_utama',
          title: 'Proses Utama'

        },
        {
          data: 'alamat',
          name: 'alamat',
          title: 'Alamat'
        },
        {
          data: 'id_company',
          name: 'id_company',
          title: 'Action',
          sortable: false,
          searchable: false,
          render: function (item, data, row) {
            @if($permission->has_create)
              return ('<div class="d-flex align-items-center">' +
              '<a href="{{ url('scheduleconfig/manage/') }}/' + row.id_company + '" class="text-body"><i class="ti ti-edit ti-sm me-2"></i></a>' +
              '</div>')
            @endif
          }
        },

      ],
      order: [[0, 'asc']],
      dom:
        '<"d-flex justify-content-between align-items-center header-actions m-1 row mt-75"' +
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
      buttons: [
          @if($permission->has_create)
        {
          text: '<i class="ti ti-settings me-0 me-sm-1 ti-xs"></i>Tambah Konfigurasi',
          className: 'add-new btn btn-sm btn-primary ms-2',
          action: function (e, dt, button, config) {
            window.location = "{{ route('master.company.create', ['next'=>'import-schedule']) }}"
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
        @endif

      ],
    });

  </script>
@endsection
