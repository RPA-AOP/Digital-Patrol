@extends('layouts/layoutMaster')
@section('title', 'Company Configuration List')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"/>
@endsection

@section('content')
  <!-- list start -->
  <section id="responsive-datatable">
    <div class="card">
      <div class="card-header pb-0 border-bottom">
        <div class="head-label pb-0">
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

@section('page-script')
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
              '<a href="{{ url('patrolconfig/manage/') }}/' + row.id_company + '" class="text-body"><i class="ti ti-edit ti-sm me-2"></i></a>' +
              '</div>')
            @endif
          }
        },

      ],
      order: [[0, 'asc']],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..',
      },
      buttons: [
          @if($permission->has_create)
        {
          text: '<i class="ti ti-settings me-0 me-sm-1 ti-xs"></i>Tambah Konfigurasi',
          className: 'add-new btn btn-sm btn-primary ms-2',
          action: function (e, dt, button, config) {
            window.location = "{{ route('master.company.create', ['next'=>'import-config']) }}"
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
