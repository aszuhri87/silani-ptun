<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Sistem Informasi Perizinan Dokumen Online PTUN Yogyakarta">
    <meta name="author" content="VarX">
    <title>Login - SIPDO | PTUN Yogyakarta</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/page-auth.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">

                        @include('sweetalert::alert')
                        <!-- Login v1 -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="brand-logo">
                                    <img src="{{asset('app-assets/images/logo.png')}}" alt="" style="width:80px%; height:80px" >
                                </a>

                                <h2 class="brand-text text-success ml-1">SIPDO | PTUN Yogyakarta</h2>
                                <br>
                                <h4 class="card-title mb-1">Selamat datang di Sistem Informasi Pelayanan Dokumen Online 👋</h4>
                                <p class="card-text mb-2">Silahkan login untuk melanjutkan</p>

                                <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username" class="form-label">Username</label>
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" aria-describedby="username" tabindex="1" required autocomplete="username" autofocus>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="password">Password</label>
                                            <a href="{{ route('password.request') }}">
                                                <small>Forgot Password?</small>
                                            </a>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="remember-me" tabindex="3" />
                                            <label class="custom-control-label" for="remember-me"> Ingat Saya </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block" tabindex="4">Sign in</button>
                                </form>

                                <p class="text-center mt-2">
                                    <span>Belum punya akun?</span>
                                    <a href="{{route('register')}}">
                                        <span>Buat Akun</span>
                                    </a>
                                </p>

                                {{-- <div class="divider my-2">
                                    <div class="divider-text">atau</div>
                                </div>

                                <div class="auth-footer-btn d-flex justify-content-center">
                                    <a href="javascript:void(0)" class="btn btn-facebook">
                                        <i data-feather="facebook"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-twitter white">
                                        <i data-feather="twitter"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-google">
                                        <i data-feather="mail"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-github">
                                        <i data-feather="github"></i>
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                        <!-- /Login v1 -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/pages/page-auth-login.js"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>
