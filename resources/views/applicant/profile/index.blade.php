@extends('layouts.app')

@section('content')

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Pengaturan Profil</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active"> Pengaturan Profil
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- account setting page -->
            <section id="page-account-settings">
                <div class="row">
                    <!-- left menu section -->
                    <div class="col-md-3 mb-2 mb-md-0">
                        <ul class="nav nav-pills flex-column nav-left">
                            <!-- general -->
                            <li class="nav-item">
                                <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                    <i data-feather="user" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">General</span>
                                </a>
                            </li>
                            <!-- change password -->
                            <li class="nav-item">
                                <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                    <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">Ubah Pasword</span>
                                </a>
                            </li>
                            <!-- information -->
                            <li class="nav-item">
                                <a class="nav-link" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                                    <i data-feather="info" class="font-medium-3 mr-1"></i>
                                    <span class="font-weight-bold">Informasi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--/ left menu section -->

                    <!-- right content section -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- general tab -->
                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                        <!-- header media -->
                                        <div class="media">
                                            <a href="javascript:void(0);" class="mr-25">
                                                @if ($data->image != null)

                                                <img src="{{asset('/files/'.$data->image)}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />

                                                @else
                                                <img src="{{asset('/files/profile.png')}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                                @endif
                                            </a>
                                            <!-- upload and reset button -->
                                            <!--/ header media -->

                                            <!-- form -->

                                        <form class="validate-form mt-2" id="change-profile">
                                            <div class="media-body mt-75 ml-1">
                                                <label for="image" class="btn btn-sm btn-success mb-75 mr-75">Upload</label>
                                                <input type="file" id="image" name="image" hidden accept="image/*"/>
                                                <input type="hidden" id="no_image" name="no_image" value="false">
                                                <button class="btn btn-sm btn-outline-secondary mb-75" type="button" id="reset_photo">Reset</button>
                                                <p>Format: JPG, GIF or PNG. Max ukuran 800kB</p>
                                            </div>
                                            <!--/ upload and reset button -->
                                        </div>
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-username">Username</label>
                                                        <input type="text" class="form-control" id="account-username" name="username" placeholder="Username" value="{{$data->username}}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-name">Nama</label>
                                                        <input type="text" class="form-control" id="account-name" name="name" placeholder="Name" value="{{$data->name}}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-e-mail">E-mail</label>
                                                        <input type="email" class="form-control" id="account-e-mail" name="email" placeholder="Email" value="{{$data->email}}" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-company">NIK</label>
                                                        <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" value="{{$data->nik}}" />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-success mt-2 mr-1">Simpan perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!--/ form -->
                                    </div>
                                    <!--/ general tab -->

                                    <!-- change password -->
                                    <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                        <!-- form -->
                                        <form class="validate-form" id="change-password">
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-old-password">Password Lama</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" class="form-control" id="account-old-password" name="password" placeholder="Password Lama" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer">
                                                                    <i data-feather="eye"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-new-password">Password Baru</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" id="account-new-password" name="new_password" class="form-control" placeholder="Password Baru" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer">
                                                                    <i data-feather="eye"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-retype-new-password">Ketik Ulang Password Baru</label>
                                                        <div class="input-group form-password-toggle input-group-merge">
                                                            <input type="password" class="form-control" id="account-retype-new-password" name="confirm-new-password" placeholder="Ketik Ulang Password Baru" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-success mr-1 mt-1">Simpan perubahan</button>

                                                </div>
                                            </div>
                                        </form>
                                        <!--/ form -->
                                    </div>
                                    <!--/ change password -->

                                    <!-- information -->
                                    <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                                        <!-- form -->
                                        <form class="validate-form" id="change-info">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="accountTextarea">Alamat</label>
                                                        <textarea class="form-control" id="address" name="address" value="{{$data->address}}" rows="4" placeholder=""></textarea>
                                                    </div>
                                                </div>


                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="account-phone">Telepon</label>
                                                        <input type="text" class="form-control" id="phone_number" placeholder="Phone number" value="{{$data->phone_number}}" name="phone_number" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                <label for="gender_edit" id="description" class="form-label">Jenis Kelamin</label>
                                                <div class="input-group mb-2">
                                                <div class="form-check form-check-inline custom-radio">
                                                    <input type="radio" id="gender_edit1" name="gender" class="form-check-input"  value="Pria">
                                                    <label class="form-check-label" for="gender_edit1">Pria</label>
                                                  </div>
                                                  <div class="form-check form-check-inline custom-radio">
                                                    <input type="radio" id="gender_edit2" name="gender" class="form-check-input" value="Wanita">
                                                    <label class="form-check-label" for="gender_edit2">Wanita</label>
                                                  </div>
                                                </div>
                                                </div>
                                                @if (Auth::user()->category == 'karyawan')
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="nip">NIP</label>
                                                            <input type="text" class="form-control" id="nip" placeholder="NIP" value="{{$data->nip}}" name="nip" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="gol">Golongan</label>
                                                            <input type="text" class="form-control" id="gol" placeholder="Golongan" value="{{$data->gol}}" name="gol" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label>Tanda Tangan</label>
                                                            <br>
                                                            <a href="javascript:void(0);" class="mr-25">
                                                                @if ($data->signature)

                                                                <img src="{{asset('/signature/'.$data->signature)}}" id="signature-upload-img" class="rounded mr-50" alt="profile image" height="80"  />

                                                                @else
                                                                <img src="{{asset('/no_image.png')}}" id="signature-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                                                @endif
                                                            </a>
                                                            <br>
                                                            <label for="signature" class="btn btn-sm btn-success mb-75 mr-75 mt-2">Upload</label>
                                                            <input type="file" id="signature" name="signature" hidden accept="image/*" />
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-success mt-1 mr-1">Simpan perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!--/ form -->
                                    </div>
                                    <!--/ information -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ right content section -->
                </div>
            </section>
            <!-- / account setting page -->

        </div>
    </div>
</div>
<!-- END: Content-->

@endsection

@push('script')
    @include('applicant.profile.script')

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#signature-upload-img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#signature").change(function(){
            readURL(this);
        });
    </script>
@endpush
