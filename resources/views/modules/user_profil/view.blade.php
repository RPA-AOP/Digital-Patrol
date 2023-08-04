@extends('layouts.dashboard')
@push('title', '- User Profil')
@section('vendor-style')
<style nonce="{{ csp_nonce() }}">
    .page-wrapper .page-body-wrapper .page-body {
        min-height: calc(100vh - 150px);
    }

    #main_table_wrapper {
        width: 99%;
    }

    .modal-loader {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.7);
    }

    .modal-loader .loader-box {
        height: 100%;
    }

    .loader-34:before,
    .loader-34:after {
        background-color: #fff !important;
    }

    .thumbnail-container {
        width: 250px;
        height: 150px;
        position: relative;
        background-color: #000000;
        border-radius: 0.25rem;
    }

    .paraf-preview {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    /* .btn-upload:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #ffffff;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    } */
</style>
@endsection

@section('content')
<div class="page-header">
    <h3>User Profil</h3>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="edit-profile">

        <form id="form-profil" method="POST" action="{{ env('APP_URL') }}user-profile" class="card needs-validation" novalidate autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="card-header pb-0">
                <h4 class="card-title mb-0">Edit Profile</h4>
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Username Menggunakan <sup class="text-danger">* Wajib dipilih</sup></label>
                            <select class="form-select @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required>
                                <option style="display: none;" value="" disabled selected>--- PILIH USERNAME ---</option>
                                @foreach ($default_user_name as $dum)
                                <option value="{{ $dum['value'] }}" {{ $dum['selected'] ? 'selected' : '' }}>{{ $dum['label'] }}</option>
                                @endforeach
                            </select>
                            @error('user_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Nama<sup class="text-danger">* Wajib diisi</sup></label>
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                   type="text" placeholder="Nama Lengkap" required
                                   value="{{ old('nama') ? old('nama') : $detail_user->nama }}"/>
                            @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nomor WA <sup class="text-danger">* Wajib diisi</sup></label>
                            <input id="telp" name="telp" class="form-control @error('telp') is-invalid @enderror"
                                   type="number" value="{{ old('telp') ? old('telp') : $detail_user->telp }}" required
                                   placeholder="Nomor Whatsapp">
                            @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Email <sup class="text-danger">* Wajib diisi</sup></label>
                            <input id="email" name="email" class="form-control @error('email') is-invalid @enderror" type="email" value=" {{ old('email') ? old('email') : $detail_user->email }}" required placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">NRK <sup class="text-danger">* Wajib diisi</sup></label>
                            <input id="nrk" name="nrk" class="form-control @error('nrk') is-invalid @enderror" type="text" placeholder="NRK" required value="{{ old('nrk') ? old('nrk') : $detail_user->nrk }}" />
                            @error('nrk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">NIP <sup class="text-danger">* Wajib diisi</sup></label>
                            <input id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror" type="text" placeholder="NIP" required value="{{ old('nip') ? old('nip') : $detail_user->nip }}" />
                            @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="form-label">NIK <sup class="text-danger">* Wajib diisi</sup></label>
                            <input id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" type="text" placeholder="NIK" required value="{{ old('nil') ? old('nik') : $detail_user->nik }}" />
                            @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Paraf <sup class="text-danger">* Wajib diisi</sup></label>
                            <figure class="w-100 paraf-container" itemprop="associatedMedia" itemscope="">
                                <div class="thumbnail-container w-100">
                                    <div class="img-thumbnail paraf-preview" @if($detail_user->paraf) style="background-image: url({{ env('APP_URL') }}user-profile/{{ $detail_user->paraf }}); min-height: 100px" @else style="background-image: url({{ asset('assets/images/lightgallry/01.jpg); min-height: 100px') }}" @endif></div>
                            </figure>
                            <input id="paraf" name="paraf" class="form-control @error('paraf') is-invalid @enderror" accept=".png, .jpg, .jpeg" type="file" />

                            @error('paraf')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="9" required>{{ old('alamat') ? old('alamat') : $detail_user->alamat }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Update Profile</button>
            </div>
        </form>
    </div>
</div>
<!-- Container-fluid Ends-->
@endsection
@section('vendor-script')
<script src="{{asset('assets/vendor/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

@section('page-script')
<script nonce="{{ csp_nonce() }}">
    $(document).ready(function() {
        $("input #form-password").validate({
            highlight: function(input) {
                $(input).addClass('is-invalid');
            },
            unhighlight: function(input) {
                $(input).removeClass('is-invalid');
            },
            errorClass: "invalid-feedback",
            errorElement: "div",
            validClass: "valid-feedback",
            rules: {
                password: "required",
                confirmpassword: {
                    equalTo: "#password"
                }
            },
            messages: {
                password: " Masukan Password Baru",
                confirmpassword: "Ulangi password baru"
            }
        })
        $("input #form-profil").validate({
            highlight: function(input) {
                $(input).addClass('is-invalid');
            },
            unhighlight: function(input) {
                $(input).removeClass('is-invalid');
            },
            errorClass: "invalid-feedback",
            errorElement: "div",
            validClass: "valid-feedback",
            rules: {
                nama: {
                    required: true,
                    minlength: 2
                },
                telp: {
                    required: true,
                    number: true,
                    min: 11
                },
                email: {
                    required: true,
                    email: true
                },
                nrk: {
                    required: true,
                    number: true,
                    min: 5
                },
                nip: {
                    required: true,
                    number: true,
                    min: 5
                },
                nik: {
                    number: true,
                    min: 15
                },
                paraf: {
                    required: "{{$detail_user->paraf ? 'false' : 'true'}}",
                    extension: "png|jpeg|jpg",
                    filesize: 10,
                }
            },
            messages: {
                nama: {
                    minlength: "Name should be at least 3 characters"
                },
                telp: {
                    required: "Nomor whatsapp wajib diisi",
                    number: "NNomor whatsapp tidak valid",
                    min: "Nomor whatsapp  harus lebih dari 11 digit"
                },
                nrk: {
                    required: "NRK harus diisi",
                    number: "NRK tidak valid",
                    min: "NRK harus lebih dari 6 digit"
                },
                nik: {
                    required: "NIK harus diisi",
                    number: "NIK tidak valid",
                    min: "NIK harus lebih dari 15 digit"
                },
                nip: {
                    required: "NIP harus diisi",
                    number: "NIP tidak valid",
                    min: "NIP harus lebih dari 6 karakter"
                },
                email: {
                    required: "Email harus diisi",
                    email: "Email tidak valid"
                },
                email: {
                    filesize: "Ukuran file maksimal 10 MB",
                    extension: 'Format file tidak didukung'
                },
            }
        });
    });
    // FILE INPUT HANDLER
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.paraf-preview').css('background-image', 'url(' + e.target.result + ')');
                $('.paraf-preview').hide();
                $('.paraf-preview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#paraf").change(function() {
        readURL(this);
    });

    @if($message = Session::get('error'))
    Swal
.fire("Error!", "{{ $message }}", "error")
    @endif
</script>
@endsection
