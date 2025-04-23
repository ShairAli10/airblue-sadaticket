<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesbrand.com/borex/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 05:24:42 GMT -->
<head>
        
        <meta charset="utf-8" />
        <title>Login | {{ config('constants.SITE_TITLE') }} Agent Portal</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/jetfavicon.png') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

   <body>
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0 align-items-center">
                    <div class="col-xxl-4 col-lg-4 col-md-6">
                        <div class="row justify-content-center g-0">
                            <div class="col-xl-10">
                                <div class="py-4">
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div class="auth-full-page-content rounded d-flex p-3 my-2">
                                                <div class="w-100">
                                                    <div class="d-flex flex-column h-100">
                                                        <div class="mb-4 mb-md-5">
                                                            <a href="{{ url('admin') }}" class="d-block auth-logo">
                                                                <img src="{{ asset('assets/images/mainLogo.jpg') }}" alt="" height="100" class="auth-logo-dark me-start">
                                                            </a>
                                                        </div>
                                                        <div class="auth-content my-auto">
                                                            <div class="text-center">
                                                                <h5 class="mb-0">Reset Password!</h5>
                                                                <p class="text-muted mt-2">you need to complete your profile Password continue to {{ config('constants.SITE_TITLE') }} Travel Agent Portal.</p>
                                                            </div>
                                                            @if(session('error'))
                                                                <div class="alert alert-danger mt-2">
                                                                    {{ session('error') }}
                                                                </div>
                                                            @endif
                                                            <form class="mt-4 pt-2" method="POST" action="{{ route('admin.reset.password.submit') }}">
                                                                @csrf
                                                                <input type="hidden" name="refkey" value="{{ $refkey }}">
                                                                <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                                    <input type="password" class="form-control pe-5" id="password-input" placeholder="Enter Password" name="password" required>
                                                                    
                                                                    <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                                    </button>
                                                                    <label for="input-password">Password</label>
                                                                    <div class="form-floating-icon">
                                                                        <i data-eva="lock-outline"></i>
                                                                    </div>
                                                                </div>
                    
                                                                <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                                                    <input type="password" class="form-control pe-5" id="cpassword-input" placeholder="Enter Confirm Password" name="cpassword" required>
                                                                    
                                                                    <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                                        <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                                    </button>
                                                                    <label for="input-password">Confirm Password</label>
                                                                    <div class="form-floating-icon">
                                                                        <i data-eva="lock-outline"></i>
                                                                    </div>
                                                                </div>
                    
                                                                <div class="row mb-4">
                                                                    <div class="col">
                                                                        <div class="form-check font-size-15">
                                                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                                                            <label class="form-check-label font-size-13" for="remember-check">
                                                                                Remember me
                                                                            </label>
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Reset Password</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-8 col-lg-8 col-md-6">
                        <div class="auth-bg bg-white py-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-white"></div>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-8">
                                    <div class="mt-4">
                                        <img src="{{ asset('assets/images/'.config('constants.icon-png')) }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="p-0 p-sm-4 px-xl-0 py-5">
                                        <div id="reviewcarouselIndicators" class="carousel slide auth-carousel" data-bs-ride="carousel">
                                            
                                        
                                            <!-- end carouselIndicators -->
                                            <div class="carousel-inner w-75 mx-auto">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-center">
                                                        <h5 class="font-size-20 mt-4">Welcome to {{ config('constants.SITE_TITLE') }} Agent Portal
                                                        </h5>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                            <!-- end carousel-inner -->
                                        </div>
                                        <!-- end review carousel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/eva-icons/eva.min.js') }}"></script>

        <script src="{{ asset('assets/js/pages/pass-addon.init.js') }}"></script>

       <script src="{{ asset('assets/js/pages/eva-icon.init.js') }}"></script>

    </body>

<!-- Mirrored from themesbrand.com/borex/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 05:24:42 GMT -->
</html>