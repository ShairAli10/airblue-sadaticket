<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', 'sadaticket.com By Binham Group')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Book Online Air Tickets Booking in Pakistan at sadaticket.com with Cheap Flights Pakistan. You Can Book International Flight Tickets From Pakistan with best rates." />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="shortcut icon" href="{{ asset('assets/images/jetfavicon.png') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('front-assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('front-assets/css/account-pages.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css" integrity="sha512-hwwdtOTYkQwW2sedIsbuP1h0mWeJe/hFOfsvNKpRB3CkRxq8EW7QMheec1Sgd8prYxGm1OM9OZcGW7/GUud5Fw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('styles')
	<style>
		.error{
			color: red !important;
		}
		.flight-details-popup-inner{
			padding: 1rem !important;
		}
	</style>
</head>
<body>
	<!-- header start -->
	<header>
		<div class="container header-nav">
			<div class="row align-items-center">
				@php
					$display = '';
					if(request()->is('checkout') || request()->is('payment') || request()->is('contact')){
						$display = "d-none d-md-block d-lg-block d-xl-block d-xxl-block";
					}
				@endphp
				<div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7c {{ $display }}">
					<div class="mob-admin-user d-none d-lg-none d-flex flex-wrap align-items-center">
						<div class="dropdown mob-user hdr-drop">
							<button type="button" class="btn login-trigger dropdown-toggle d-flex flex-wrap justify-content-between align-items-center pt-0" data-toggle="dropdown">
								<div class="user-details d-flex flex-wrap mr-3">
									<a href="#" class="sign-in mr-2">Sign in</a>
								</div>
								<div class="user-img d-flex flex-wrap">
									<a href="#">
										<svg class="mob-user-ico" xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
											<path d="M11.2891 10.15C10.9944 9.45183 10.5666 8.81766 10.0297 8.28281C9.49446 7.74642 8.8604 7.31876 8.16254 7.02344C8.15629 7.02031 8.15004 7.01875 8.14379 7.01562C9.11722 6.3125 9.75004 5.16719 9.75004 3.875C9.75004 1.73438 8.01566 0 5.87504 0C3.73441 0 2.00004 1.73438 2.00004 3.875C2.00004 5.16719 2.63285 6.3125 3.60629 7.01719C3.60004 7.02031 3.59379 7.02187 3.58754 7.025C2.88754 7.32031 2.25941 7.74375 1.72035 8.28438C1.18396 8.81964 0.756296 9.4537 0.460976 10.1516C0.170855 10.8348 0.0143858 11.5673 3.90719e-05 12.3094C-0.000377967 12.3261 0.00254708 12.3426 0.00864193 12.3582C0.0147368 12.3737 0.0238781 12.3879 0.0355272 12.3998C0.0471763 12.4117 0.0610975 12.4212 0.0764706 12.4277C0.0918436 12.4342 0.108358 12.4375 0.125039 12.4375H1.06254C1.13129 12.4375 1.18598 12.3828 1.18754 12.3156C1.21879 11.1094 1.70316 9.97969 2.55941 9.12344C3.44535 8.2375 4.62191 7.75 5.87504 7.75C7.12816 7.75 8.30473 8.2375 9.19066 9.12344C10.0469 9.97969 10.5313 11.1094 10.5625 12.3156C10.5641 12.3844 10.6188 12.4375 10.6875 12.4375H11.625C11.6417 12.4375 11.6582 12.4342 11.6736 12.4277C11.689 12.4212 11.7029 12.4117 11.7145 12.3998C11.7262 12.3879 11.7353 12.3737 11.7414 12.3582C11.7475 12.3426 11.7505 12.3261 11.75 12.3094C11.7344 11.5625 11.5797 10.8359 11.2891 10.15ZM5.87504 6.5625C5.15785 6.5625 4.48285 6.28281 3.97504 5.775C3.46723 5.26719 3.18754 4.59219 3.18754 3.875C3.18754 3.15781 3.46723 2.48281 3.97504 1.975C4.48285 1.46719 5.15785 1.1875 5.87504 1.1875C6.59223 1.1875 7.26722 1.46719 7.77504 1.975C8.28285 2.48281 8.56254 3.15781 8.56254 3.875C8.56254 4.59219 8.28285 5.26719 7.77504 5.775C7.26722 6.28281 6.59223 6.5625 5.87504 6.5625Z" fill="#333333"></path>
										</svg>
									</a>
								</div>
							</button>
							<div class="dropdown-menu signin">
								<div class="row no-gutter">
									<div class="col-lg-12 col-12 mb-3">
										<span class=" d-block w-100 p-3 account-head" style="border-bottom: 1px solid rgba(0,0,0,.1);"><b>Customer Login</b></span>
									</div>
									<div class="col-lg-6 col-6" style="border-right: 1px solid rgba(0,0,0,.1);">
										<form class="flip-item flip-front" role="form" id="login-form" action="" method="POST">
											<div class="mb-2 email">
												<input type="email" name="email" class="form-control" placeholder="Email ID" minlength="6" required="">
											</div>
											<div class="mb-3 password">
												<input type="password" name="password" class="form-control" placeholder="Password" minlength="6" required="">
											</div>
											<div class="mb-3">
												<a class="forgot-pass">Forgot Password?</a>
											</div>
											<button type="submit" class="button green_btn w-100 form-button">Login</button>
										</form>
									</div>
									<div class="col-lg-6 col-6 ">
										<a style="background:#4AC2EF;text-decoration: none;color: white;font-size: 14px;padding: 8px 20px;border-radius: 10px;" class="twitter" href="" role="button">
											<svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M14.1973 1.36903C13.6752 1.60038 13.1143 1.75669 12.5247 1.82735C13.1331 1.46331 13.5882 0.890368 13.8052 0.215415C13.2336 0.554928 12.6081 0.793908 11.9557 0.921965C11.517 0.453557 10.9359 0.143089 10.3027 0.0387617C9.66947 -0.0655652 9.01951 0.0420865 8.45373 0.345003C7.88796 0.64792 7.43801 1.12915 7.17376 1.71399C6.90951 2.29883 6.84574 2.95455 6.99234 3.57934C5.83415 3.52119 4.70114 3.22016 3.66682 2.69578C2.6325 2.17141 1.72001 1.43541 0.988544 0.535551C0.738438 0.966984 0.594627 1.4672 0.594627 1.99992C0.594348 2.4795 0.712448 2.95173 0.938447 3.37471C1.16445 3.7977 1.49136 4.15836 1.89018 4.4247C1.42765 4.40998 0.975334 4.28501 0.570867 4.06017V4.09769C0.570821 4.77031 0.803486 5.42223 1.22939 5.94284C1.65529 6.46345 2.24819 6.82067 2.90748 6.9539C2.47842 7.07002 2.02857 7.08712 1.59193 7.00392C1.77794 7.58267 2.14028 8.08877 2.62822 8.45136C3.11616 8.81395 3.70527 9.01488 4.31308 9.02603C3.28129 9.836 2.00703 10.2754 0.695295 10.2734C0.462934 10.2735 0.230771 10.2599 0 10.2328C1.33149 11.0889 2.88143 11.5432 4.46439 11.5415C9.82292 11.5415 12.7523 7.10334 12.7523 3.2542C12.7523 3.12915 12.7492 3.00285 12.7435 2.87779C13.3133 2.46573 13.8052 1.95546 14.196 1.37091L14.1973 1.36903Z" fill="white"></path>
											</svg> Twitter
										</a>
										<br><br>
											
										<a style="background:#D94D32; color:white;text-decoration: none;font-size: 14px;padding: 8px 20px;border-radius: 10px;" id="google-login" class="google btn-google" href="javascript:;" role="button">
											<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
												<rect width="15" height="15" fill="white"></rect>
												<path fill-rule="evenodd" clip-rule="evenodd" d="M14.4 7.66451C14.4 7.15485 14.3543 6.66479 14.2693 6.19434H7.5V8.97459H11.3682C11.2016 9.87303 10.6952 10.6343 9.93395 11.1439V12.9473H12.2568C13.6159 11.696 14.4 9.85343 14.4 7.66451Z" fill="#4285F4"></path>
												<path fill-rule="evenodd" clip-rule="evenodd" d="M7.49992 14.6881C9.44054 14.6881 11.0675 14.0445 12.2567 12.9468L9.93387 11.1433C9.29026 11.5746 8.46696 11.8294 7.49992 11.8294C5.6279 11.8294 4.04338 10.5651 3.47818 8.86621H1.0769V10.7284C2.25957 13.0774 4.69026 14.6881 7.49992 14.6881Z" fill="#34A853"></path>
												<path fill-rule="evenodd" clip-rule="evenodd" d="M3.47827 8.86593C3.33452 8.43468 3.25284 7.97402 3.25284 7.5003C3.25284 7.02658 3.33452 6.56593 3.47827 6.13468V4.27246H1.07699C0.590199 5.24277 0.3125 6.3405 0.3125 7.5003C0.3125 8.6601 0.590199 9.75783 1.07699 10.7281L3.47827 8.86593Z" fill="#FBBC05"></path>
												<path fill-rule="evenodd" clip-rule="evenodd" d="M7.49992 3.17116C8.55517 3.17116 9.50262 3.53381 10.2475 4.24602L12.309 2.18452C11.0643 1.02472 9.43727 0.3125 7.49992 0.3125C4.69026 0.3125 2.25957 1.92315 1.0769 4.27216L3.47818 6.13437C4.04338 4.43551 5.6279 3.17116 7.49992 3.17116Z" fill="#EA4335"></path>
											</svg>
											Google+
										</a>
									</div>
								</div>
								<hr class="mb-0">
								<div class="row">
									<div class="col-lg-6 col-6 mt-3 create-one-ss">
										<p class="mb-0">Are you a {{ config('constants.SITE_TITLE') }} Agent?</p>
									</div>
									<div class="col-lg-6 col-6 mt-3">
										<a href="" class="button green_btn w-100 form-button">Agent Login</a>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<nav class="navbar navbar-expand-lg  justify-between">
						<a class="navbar-brand" href="{{ url('/')}}">
							<img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}" alt="logo">
						</a>
						<a type="button" class="btn sign-in-mobile d-flex flex-wrap justify-content-between align-items-center" data-toggle="dropdown">
							<div class="user-img d-flex flex-wrap">
								<svg class="mob-user-ico" xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
									<path d="M11.2891 10.15C10.9944 9.45183 10.5666 8.81766 10.0297 8.28281C9.49446 7.74642 8.8604 7.31876 8.16254 7.02344C8.15629 7.02031 8.15004 7.01875 8.14379 7.01562C9.11722 6.3125 9.75004 5.16719 9.75004 3.875C9.75004 1.73438 8.01566 0 5.87504 0C3.73441 0 2.00004 1.73438 2.00004 3.875C2.00004 5.16719 2.63285 6.3125 3.60629 7.01719C3.60004 7.02031 3.59379 7.02187 3.58754 7.025C2.88754 7.32031 2.25941 7.74375 1.72035 8.28438C1.18396 8.81964 0.756296 9.4537 0.460976 10.1516C0.170855 10.8348 0.0143858 11.5673 3.90719e-05 12.3094C-0.000377967 12.3261 0.00254708 12.3426 0.00864193 12.3582C0.0147368 12.3737 0.0238781 12.3879 0.0355272 12.3998C0.0471763 12.4117 0.0610975 12.4212 0.0764706 12.4277C0.0918436 12.4342 0.108358 12.4375 0.125039 12.4375H1.06254C1.13129 12.4375 1.18598 12.3828 1.18754 12.3156C1.21879 11.1094 1.70316 9.97969 2.55941 9.12344C3.44535 8.2375 4.62191 7.75 5.87504 7.75C7.12816 7.75 8.30473 8.2375 9.19066 9.12344C10.0469 9.97969 10.5313 11.1094 10.5625 12.3156C10.5641 12.3844 10.6188 12.4375 10.6875 12.4375H11.625C11.6417 12.4375 11.6582 12.4342 11.6736 12.4277C11.689 12.4212 11.7029 12.4117 11.7145 12.3998C11.7262 12.3879 11.7353 12.3737 11.7414 12.3582C11.7475 12.3426 11.7505 12.3261 11.75 12.3094C11.7344 11.5625 11.5797 10.8359 11.2891 10.15ZM5.87504 6.5625C5.15785 6.5625 4.48285 6.28281 3.97504 5.775C3.46723 5.26719 3.18754 4.59219 3.18754 3.875C3.18754 3.15781 3.46723 2.48281 3.97504 1.975C4.48285 1.46719 5.15785 1.1875 5.87504 1.1875C6.59223 1.1875 7.26722 1.46719 7.77504 1.975C8.28285 2.48281 8.56254 3.15781 8.56254 3.875C8.56254 4.59219 8.28285 5.26719 7.77504 5.775C7.26722 6.28281 6.59223 6.5625 5.87504 6.5625Z" fill="#333333"></path>
								</svg>
							</div>
						</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
							<span class="navbar-toggler-icon d-flex flex-wrap align-items-center justify-content-center">
							</span>
						</button>
						
						<div class="collapse navbar-collapse" id="collapsibleNavbar">
							<ul class="navbar-nav">
								<li class="nav-item">
									<a class="nav-link" href="">Flights</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="">Hotels</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="">Cars</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="">Holidays</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="">Transfer</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="">Insurance</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="">Activities</a>
								</li>
								<li class="manage-booking-mobile nav-item">
									<a href="{{ route('mybookings') }}" class="manage-booking nav-link text-decoration-none">Manage booking</a>
								</li>
							</ul>
						</div>
					</nav>
				</div>
				<div class="header-right-wrapper col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 pt-2 pb-2 d-flex flex-wrap align-items-center justify-content-end mb-bg-top">
					<div class="align-items-center row w-100 pe-sm-3">
						<div class="header-right col-md-12 d-flex flex-wrap justify-content-end align-items-center">
							
							<div class="dropdown hdr-drop desktop">
								@guest
									<a class="btn login-trigger dropdown-toggle sign-in-toggle align-items-center" data-toggle="dropdown">
										<div class="d-signin d-flex flex-wrap align-items-center pl-5 pr-2">
											<span class="sign-in text-capitalize">Sign in</span>
										</div>
									</a>
									<a class="btn signup-trigger dropdown-toggle sign-in-toggle align-items-center">
										<div class="d-signin d-flex flex-wrap align-items-center pl-5 pr-2">
											<span class="sign-in text-capitalize">Sign Up</span>
										</div>
									</a>
								@else
									<button type="button" class="btn dropdown-toggle sign-in-toggle d-flex flex-wrap justify-content-between align-items-center signInToggleBtn" data-toggle="dropdown">
										<div class="user-img d-flex flex-wrap">
											<img src="{{ asset('front-assets/images/user.png') }}" alt="">
										</div>
									</button>
									<div class="dropdown-menu signin">
										<div class="row no-gutter text-center">
											<div class="col-lg-12 col-12">
												<span class="d-block w-100 p-1 account-head" style="font-size:12px;">
													<a href="{{ route('mybookings') }}" class="manage-booking manage-booking-desk text-decoration-none">Manage Bookings</a>
												</span>
											</div>
											<div class="col-lg-12 col-12">
												<span class="d-block w-100 p-1 account-head" style="border-bottom: 1px solid rgba(0,0,0,.1); font-size:12px;">
													<a href="{{ route('mywallet') }}" class="manage-booking manage-booking-desk text-decoration-none">My Wallet</a>
												</span>
											</div>
											<div class="col-lg-12 col-12 text-center">
												<form action="{{ route('logout.customer') }}" method="POST">
													@csrf
													<button type="submit" class="button btn-warning w-100 form-button border-0 ">Logout</button>
												</form>
											</div>
											
										</div>
									</div>
								@endguest
							</div>
							@if(auth()->check())
								<span class="mt-2">{{ auth()->user()->first_name }}</span>
							@endif
									
									
							<div class="dropdown d-none">
								<a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
									AED
								</a>
								
								<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<li><a class="dropdown-item" href="#">Action</a></li>
									<li><a class="dropdown-item" href="#">Another action</a></li>
									<li><a class="dropdown-item" href="#">Something else here</a></li>
								</ul>
							</div>
									
							<div class="dropdown d-none">
								<button type="button" class="btn btn-primary dropdown-toggle language-drop" data-toggle="dropdown">
									<span class="language" id="lang_selected">EN</span>
									<img src="" alt="flag">
								</button>
								<div class="dropdown-menu" id="land_select">
									<a class="dropdown-item" href="/en">English</a>
									<a class="dropdown-item" href="/ar">Arabic</a>
								</div>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
	</header>
    <!-- header end -->
	{{-- ========================= --}}
		@if(session('message'))
			<div class="row">
				<div class="col-6 offset-3">
					<div class="alert alert-danger">
						{{ session('message') }}
					</div>
				</div>
			</div>
		@endif
        @yield('content')
	{{-- ========================= --}}


    <!-- footer starts here -->
	@if(request()->url() === request()->root())
    <section class="mt-5 center-mobile pt-0">
		<div class="footer-bg footer-top d-flex justify-content-center px-md-5 rounded-lg footer-second pt-5 mt-2 mb-2">
			<div class="row justify-content-center px-md-1 px-lg-1 px-lg-2 w-100">
				<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3 mobile-one p-0">
					<img src="{{ asset('front-assets/images/Mobile.jpg') }}" alt="mobile app">
				</div>
				<div class="take-jet-keypoints my-4 my-sm-4 my-md-0 col-sm-12 col-md-8 col-lg-6 col-xl-6">
					<img class="position-absolute arrow" src="{{ asset('front-assets/images/ftr-arrow.svg') }}" alt="arrow icon">
					<h5 class="take-font px-lg-4 mb-sm-4 mb-md-4 mt-sm-5 mt-md-0">
						Take sadaticket.com With You Wherever You Go
					</h5>
					<div class="row px-lg-4">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="d-flex align-items-center mb-md-0">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">3 Steps Instant Booking</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Best Flight Ticket Deals</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Multiple Payment Options</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Cheapest flights from Pakistan</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">24/7 Support</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Affordable Travel Packages</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Business Travel Booking Service</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Cheap Flight & Hotel Packages</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Travel Assistance Services</label>
							</div>
							<div class="d-flex align-items-center">
								<img src="{{ asset('front-assets/images/akar-icons_check-box-fill.svg') }}" alt="Bullet Point 1">
								<label class="form-check-label">Quick Refund For Your Booking</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-lg-3 col-xl-3">
					<div class="row footer-scanner">
						<div class="col-md-6 mt-md-4 mt-lg-0 text-center">
							<img class="mb-2" src="{{ asset('front-assets/images/AndroidQR.jpg') }}" alt="Sadaticket Play Store QR Code" width="120" height="120">
							<a href="" target="_blank"><img class="app-store" src="{{ asset('front-assets/images/google-play.svg') }}" alt="sadaticket Play Store App" style="width: 120px;"></a>
						</div>
						<div class="col-md-6 mt-md-4 mt-lg-0 text-center">
							<img class="mb-2" src="{{ asset('front-assets/images/AndroidQR.jpg') }}" width="120" height="120" alt="sadaticket Apple Store QR Code">
							<a href="" target="_blank"><img class="app-store" src="{{ asset('front-assets/images/appstore.svg') }}" alt="sadaticket Apple Store App" style="width: 120px;"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endif
	<div class="footer-upper container-fluid mb-2">
		<div class="container">
			<div class="row footer-upper-row pt-3 pb-3">
				<div class="mb-4 mb-sm-3 mb-md-0 col-sm-12 col-md-6 col-lg-4 d-flex align-items-center">
					<h6 class="mr-4 mb-0 iata-font">IATA CERTIFIED</h6>
					<img class="iata-logo" src="{{ asset('front-assets/images/iata.png')}}" alt="">
				</div>
				<div class="mb-4 mb-sm-3 mb-md-0 col-sm-12 col-md-6 col-lg-4 d-flex align-items-center">
					<h6 class="mr-4">100% SECURED BY</h6>
					<img src="{{ asset('front-assets/images/secured.png')}}" alt="">
				</div>
				<div class="mb-4 mt-sm-4 mt-md-4 mt-lg-0 mb-sm-3 mb-md-0 col-sm-12 col-md-6 col-lg-4 mx-md-auto d-flex flex-sm-column payment flex-md-column flex-lg-column flex-xl-row align-items-center">
					<h6 class="mr-2">WE ACCEPT</h6>
					<img src="{{ asset('front-assets/images/payments.png')}}" alt="">
				</div>
			</div>
		</div>
	</div>
	
	<div class="container-fluid footer-wrapper footer-main {{ $display }}">
		<div class="container pt-4 pb-4">
			
			<div class="row">
				<div class="col-md-12 col-lg-5">
					<div class="footer-logo mb-3">
						<img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}"/>
					</div>
					<div class="footer-description">
						<p>sadaticket.com booking online international and domestic air tickets, hotels, cars etc.sadaticket is a project of Binham Group. We offer Cheap flights from Pakistan and cheap airfare to fly Pakistan. Clients can search rental cars discount flights and hotels including Travel Tips.</p>
					</div>
				</div>
				
				<div class="col-md-12 col-lg-7">
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer-menu">
								<h6>sadaticket.COM</h6>
								<ul class="p-0 list-unstyled">
									<li>Blog</li>
									<li>About Us</li>
									<li>Contact Us</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-xs-6">
							<div class="footer-menu">
								<h6 class="text-uppercase">Products</h6>
								<ul class="p-0 list-unstyled">
									<li>Flights</li>
									<li>Hotels</li>
									<li>Cars</li>
									<li>Insurance</li>
									<li>Holidays</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-xs-6">
							<div class="footer-menu">
								<h6 class="text-uppercase">Partners</h6>
								<ul class="p-0 list-unstyled">
									<li>Agent Login</li>
									<li>Become an Affiliate</li>
									<li>API</li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-xs-6">
							<div class="footer-contact-info">
								<h6 class="text-uppercase">GET IN TOUCH</h6>
								<h6 class="mb-0">For Reservation</h6>
								<a class="text-dark text-decoration-none">sales@sadaticket.com</a>
								<h6 class="mb-0">For Holidays:</h6>
								<a class="text-dark text-decoration-none">holidays@sadaticket.com</a>
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
			
		</div>
	</div>
	
	<!-- footer bottom -->
	
	<div class="container footer-bottom">
		<div class="align-items-center row pt-2 pb-2">
			<div class="col-md-12 col-lg-4">
				<p class="copyright-font">
					Copyright © 2023 sadaticket.com All rights reserved.
				</p>
			</div>
			<div class="col-md-12 footer-btm-img col-lg-4 text-center mb-3 mb-sm-3 mb-md-3 mb-lg-0">
				<img src="{{ asset('front-assets/images/tripadviser.png')}}" alt="tripadvisor">
			</div>
			<div class="col-md-12 mx-md-auto col-lg-4">
				<p>sadaticket.com is a registerd trademark of SadaTicket</p>
			</div>	
		</div>
	</div>
    @include('front.includes.login')
    @include('front.includes.signup')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js" integrity="sha512-MqEDqB7me8klOYxXXQlB4LaNf9V9S0+sG1i8LtPOYmHqICuEZ9ZLbyV3qIfADg2UJcLyCm4fawNiFvnYbcBJ1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- Alpine Plugins -->
	<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
	@yield('scripts')
	
	<script>
		$(document).ready(function () {
			// Add click event to the button
			$('.signInToggleBtn').click(function () {
				// Toggle the visibility of the dropdown menu
				var signInMenu = $('.signin');
				if (signInMenu.css('display') === 'none') {
					signInMenu.css('display', 'block');
				} else {
					signInMenu.css('display', 'none');
				}
			});
		});

		$(document).ready(function(){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				}
			});

			$('.login-trigger, .sign-in-mobile').click(function(){
				$('.login-popup-wrapper').addClass('show');
				$('.login-popup-wrapper').fadeIn(500)
			});
			$('.close-login-popup').click(function(){
				$('.login-popup-wrapper').removeClass('show');
				$('#loginButton').show();
				$('#otp_div').html('');
				$('.email-error').html('');
				$('.email-error').hide();
				$('#login-email').val('');
			});

			$('.signup-trigger').click(function(){
				$('.signup-popup-wrapper').addClass('show');
				$('.signup-popup-wrapper').fadeIn(500);
			});

			$('.close-signup-popup').click(function(){
				$('.signup-popup-wrapper').removeClass('show');
			});
		});
	</script>
	<script>
		// ========================Login and Signup Ajax===================\\
		$(document).ready(function() {
			// =========================Login===================\\
			$("#loginButton").click(function(e) {
				e.preventDefault();
				var email = $("#login-email").val();
				if(email !=''){
					$('#loginButton').prop('disabled', true);
					var spinnerHtml = '<div class="d-flex justify-content-center">' +
							'<div class="spinner-border spinner-border-sm text-secondary" role="status">' +
							'<span class="visually-hidden">Loading...</span>' +
							'</div>' +
							'</div>';
					$('#otp_div').html(spinnerHtml);
				}

				
				$.ajax({
					url: "{{ route('otp.customer') }}",
					method: "POST",
					data: {
						email: email,
						_token: "{{ csrf_token() }}"
					},
					success: function(response) {
						if(response.status == 'success'){
							generateOtpInputBoxes();
							$('#loginButton').prop('disabled', false);
							$('.email-error').html('');
							$('.email-error').hide();
						}
					},
					error: function(xhr, status, error) {
						$('#loginButton').prop('disabled', false)
						var responseObject = JSON.parse(xhr.responseText);
						
						if(responseObject.error == 'not found' || responseObject.error == 'not verified'){
							$('.email-error').html(responseObject.message);
							swal("OOPs!", responseObject.message, "error")
						}

						if(responseObject.errors.email){
							$('.email-error').html(responseObject.errors.email);
							$('.email-error').show();
						}else{
							$('.email-error').html('');
							$('.email-error').hide();
						}
					}
				});
			});
			// ========================Signup Ajax===================\\
			$("#signupButton").click(function(e) {
				e.preventDefault();

				var firstName = $("#signup-firstname").val();
				var lastName = $("#signup-lastname").val();
				var email = $("#signup-email").val();
				var phone = $("#signup-phone").val();
				if (firstName !== '' && lastName !== '' && email !== '' && phone !== '') {
					$('#signupButton').prop('disabled', true);
					var spinnerHtml = '<div class="d-flex justify-content-center">' +
							'<div class="spinner-border spinner-border-sm text-secondary" role="status">' +
							'<span class="visually-hidden">Loading...</span>' +
							'</div>' +
							'</div>';
					$('#spinner').html(spinnerHtml);
				}
				$.ajax({
					url: "{{ route('signup.customer') }}",
					method: "POST",
					data: {
						first_name: firstName,
						last_name: lastName,
						email: email,
						phone: phone,
						_token: "{{ csrf_token() }}"
					},
					success: function(response) {
						console.log(response);
						swal("Thankyou..!", "Please verify your email", "success");
						$('.signup-popup-wrapper').removeClass('show');
						$('#spinner').html('');
						$("#signup-firstname").val('');
						$("#signup-lastname").val('');
						$("#signup-email").val('');
						$("#signup-phone").val('');
						$(".error").html('');
					},
					error: function(xhr, status, error) {
						$('#spinner').html('');
						$('#signupButton').prop('disabled', false);
						// Handle validation errors or other issues
						var responseObject = JSON.parse(xhr.responseText);

						if(responseObject.errors.first_name) {
							$('.firstname-error').html(responseObject.errors.first_name);
							$('.firstname-error').show();
						} else {
							$('.firstname-error').html('');
							$('.firstname-error').hide();
						}

						if(responseObject.errors.last_name) {
							$('.lastname-error').html(responseObject.errors.last_name);
							$('.lastname-error').show();
						} else {
							$('.lastname-error').html('');
							$('.lastname-error').hide();
						}

						if(responseObject.errors.email) {
							$('.email-error').html(responseObject.errors.email);
							$('.email-error').show();
						} else {
							$('.email-error').html('');
							$('.email-error').hide();
						}

						if(responseObject.errors.phone) {
							$('.phone-error').html(responseObject.errors.phone);
							$('.phone-error').show();
						} else {
							$('.phone-error').html('');
							$('.phone-error').hide();
						}

						if(responseObject.errors.password) {
							$('.password-error').html(responseObject.errors.password);
							$('.password-error').show();
						} else {
							$('.password-error').html('');
							$('.password-error').hide();
						}
					}
				});
			});

		});
		
		// // // // // Login Submit \\ \\ \\ \\ \\ \\
		$(document).on('click', '#loginSubmit', function(e) {
			e.preventDefault();

			// Retrieve OTP code values
			var otp1 = $('#otp1').val();
			var otp2 = $('#otp2').val();
			var otp3 = $('#otp3').val();
			var otp4 = $('#otp4').val();
			var otp5 = $('#otp5').val();
			var otp6 = $('#otp6').val();

			// Construct the OTP code
			var email = $("#login-email").val();
			var otpCode = otp1 + otp2 + otp3 + otp4 + otp5 + otp6;
			console.log(otpCode);
			// Your AJAX POST request
			$.ajax({
				url: "{{ route('login.customer') }}",
				method: "POST",
				data: {
					otp_code: otpCode,
					email:email,
					_token: "{{ csrf_token() }}"
				},
				success: function(response) {
					location.reload();
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
					// $('.otp-error').

					var responseObject = JSON.parse(xhr.responseText);
					if(responseObject.error == 'not authenticated'){
						$('.otp-error').html(responseObject.message);
						$('.otp-error').show();
					}
				}
			});
		});
	</script>
	{{-- Login Otp --}}
	<script>
		function generateOtpInputBoxes() {
			$('#loginButton').hide();
			var html = '<div class="input-group f-14px login-popup-otp-field mb-2">' +
				'<div class="row">' +
				'<div class="col-6">' +
				'<label class="form-label">OTP</label>' +
				'</div>' +
				'<div class="col-6 text-end">' +
				'<!--<span>12</span>-->' +
				'</div>' +
				'</div>' +
				'<div class="otp-boxes d-flex">' +
				'<div class="otp-boxes d-flex">' +
				'<input class="form-control rounded mr-1" type="text" id="otp1" maxlength="1" />' +
				'<input class="form-control rounded mr-1" type="text" id="otp2" maxlength="1" />' +
				'<input class="form-control rounded mr-1" type="text" id="otp3" maxlength="1" />' +
				'<input class="form-control rounded mr-1" type="text" id="otp4" maxlength="1" />' +
				'<input class="form-control rounded mr-1" type="text" id="otp5" maxlength="1" />' +
				'<input class="form-control rounded" type="text" id="otp6" maxlength="1" />' +
				'</div>' +
				'</div>' +
				'<span class="error otp-error" style="display:none;"></span>' +
				'</div>' +
				'<div class="input-group f-14px login-popup-otp-field mb-2">' +
				'<button class="mb-5 align-center" style="border:none; padding:0;" disabled>Resend OTP</button>' +
				'<button class="green_btn w-100 edit-profile-btn" id="loginSubmit">Continue </button>' +
				'</div>';

			var otpDiv = $('#otp_div');
			otpDiv.html(html); // Use html() to set the inner HTML content
		}
        $(document).on('input focus keydown', '.otp-boxes input', function (event) {
			var otpInputs = $('.otp-boxes input');
			var index = otpInputs.index(this);

			if (event.type === 'input') {
				if (this.value.length === this.maxLength) {
					if (index < otpInputs.length - 1) {
						otpInputs.eq(index + 1).focus();
					}
				} else if (this.value.length === 0) {
					if (index > 0) {
						otpInputs.eq(index - 1).focus();
					}
				}
			} else if (event.type === 'focus') {
				this.select();
			} else if (event.type === 'keydown') {
				if (event.key === 'ArrowLeft' && index > 0) {
					otpInputs.eq(index - 1).focus();
				} else if (event.key === 'ArrowRight' && index < otpInputs.length - 1) {
					otpInputs.eq(index + 1).focus();
				}
			}
		});

    </script>
</body>
</html>