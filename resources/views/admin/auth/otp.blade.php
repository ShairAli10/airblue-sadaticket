<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesbrand.com/borex/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 05:24:42 GMT -->
<head>
        
    <meta charset="utf-8" />
    <title>Login | sadaticket.com By Binham Group</title>
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
    <style>
        .error{
            color: red;
        }
        .otp-input {
            border: 1px solid #3b76e1 !important;
            text-align: center;
        }
    </style>

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
                                                                <img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}" alt="" height="40" class="auth-logo-dark me-start">
                                                            </a>
                                                        </div>
                                                        <div class="auth-content my-auto">
                                                            <div class="text-center">
                                                                <h4>Verify your email</h4>
                                                                <p class="mb-5">Please enter the 6 digit code sent to <span class="fw-bold">{{ $email }}</span></p>
                                                            </div>
                                                            <form id="otp-form">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <input type="hidden" name="refkey" value="{{ $refkey }}" id="refkey">
                                                                        <input type="hidden" name="email" value="{{ $email }}" id="email">
                                                                        <div class="mb-3 otp-boxes d-flex">
                                                                            <input class="form-control rounded me-2 otp-input" type="text" id="otp1" maxlength="1" autocomplete="off"/>
                                                                            <input class="form-control rounded me-2 otp-input" type="text" id="otp2" maxlength="1" autocomplete="off"/>
                                                                            <input class="form-control rounded me-2 otp-input" type="text" id="otp3" maxlength="1" autocomplete="off"/>
                                                                            <input class="form-control rounded me-2 otp-input" type="text" id="otp4" maxlength="1" autocomplete="off"/>
                                                                            <input class="form-control rounded me-2 otp-input" type="text" id="otp5" maxlength="1" autocomplete="off"/>
                                                                            <input class="form-control rounded me-2 otp-input" type="text" id="otp6" maxlength="1" autocomplete="off"/>
                                                                        </div>
                                                                    </div>
                                                                    <span class="error-otp error"></span>
                                                                </div>
                                        
                                                                <div class="mt-4">
                                                                    <button class="btn btn-primary w-100 waves-effect waves-light" id="otp-submit" type="submit">Confirm</button>
                                                                </div>
                                                            </form>
                                        
                                                            <div class="mt-4 pt-3 text-center">
                                                                <p class="text-muted mb-0">Didn't receive an email ? 
                                                                    <a href="javascript:void(0)" class="text-primary fw-semibold" id="resend-otp">
                                                                        Resend
                                                                    </a>
                                                                </p>
                                                            </div>
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
                                                        <h5 class="font-size-20 mt-4">Welcome to {{ config('constants.SITE_TITLE') }} B2C
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/eva-icons/eva.min.js') }}"></script>

        <script src="{{ asset('assets/js/pages/pass-addon.init.js') }}"></script>

       <script src="{{ asset('assets/js/pages/eva-icon.init.js') }}"></script>
       <script>
        // |||||||||||||||||||OTP SUBMIT||||||||||||||||
        $(document).ready(function() {
            // Function to handle form submission
            $('#otp-form').submit(function(event) {
                $('#otp-submit').attr('disabled', true);
                event.preventDefault();
    
                var otpInputs = $('.otp-input');
                var otp = '';
                otpInputs.each(function() {
                    otp += $(this).val();
                });
                if (otp.length === 6 && /^\d{6}$/.test(otp)) {
                    $('.error-otp').text('');
                    var formData = new FormData($(this)[0]);
                    formData.append('otp', otp);
    
                    $.ajax({
                        url: '{{ url("admin/otp-submit") }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.success) {
                                window.location.href = data.redirect;
                            } else {
                                $('.error-otp').text(data.error);
                            }
                            $('#otp-submit').attr('disabled', false);
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error('There was a problem with the fetch operation:', errorThrown);
                        },
                        complete: function() {
                            $('#otp-submit').attr('disabled', false);
                        }
                    });
                } else {
                    $('.error-otp').text('Please enter a valid 6-digit OTP.');
                    $('#otp-submit').attr('disabled', false);
                }
            });
    
            $(document).on('keydown', '.otp-input', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    $('#otp-form').submit();
                }
            });
        });
    
        // ||||||||||||||||||||RESEND OTP||||||||||||||||
        $(document).ready(function() {
            $('#resend-otp').click(function() {
                // $(this).off('click');
    
                var email = $('#email').val();
                var refkey = $('#refkey').val();
                $.ajax({
                    url: "{{ route('admin.resendOtp') }}",
                    type: "POST",
                    data: {
                        email: email,
                        refkey: refkey,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        $('#custom_toast').toast('show');
                        $('#custom_toast .toast-body').text(response.message);
                        $(this).on('click');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                    complete: function() {
                        // $(this).on('click');
                    }
                });
            });
        });
        // ||||||||||||||||||||||||||||ON KEY PRESS||||||||||||||||||||||||||||||||\\
        $(document).on('input focus keydown', '.otp-boxes input', function (event) {
            var otpInputs = $('.otp-boxes input');
            var index = otpInputs.index(this);
    
            if (event.type === 'input') {
                if (this.value.length === this.maxLength && !isNaN(this.value)) {
                    if (index < otpInputs.length - 1) {
                        otpInputs.eq(index + 1).focus();
                    }
                } else if (this.value.length === 0) {
                    if (index > 0) {
                        otpInputs.eq(index - 1).focus();
                    }
                } else {
                    this.value = ''; // Clear the input if non-numeric characters are entered
                }
            } else if (event.type === 'focus') {
                this.select();
            } else if (event.type === 'keydown') {
                if (!/[0-9]/.test(event.key) && event.key !== 'Backspace') {
                    event.preventDefault(); // Prevent entering non-numeric characters
                } else {
                    if (event.key === 'ArrowLeft' && index > 0) {
                        otpInputs.eq(index - 1).focus();
                    } else if (event.key === 'ArrowRight' && index < otpInputs.length - 1) {
                        otpInputs.eq(index + 1).focus();
                    } else if (event.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        otpInputs.eq(index - 1).focus().select(); // Move focus to previous input and select its content
                    }
                }
            }
        });
    </script>
    </body>

<!-- Mirrored from themesbrand.com/borex/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Mar 2023 05:24:42 GMT -->
</html>