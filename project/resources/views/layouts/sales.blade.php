<!doctype html>
<html lang="en" dir="ltr">

<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="author" content="GeniusOcean">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Title -->
		<title>{{$gs->title}}</title>
		<!-- favicon -->
		<link rel="icon"  type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}"/>
		<!-- Bootstrap -->
		<link href="{{asset('assets/sales/css/bootstrap.min.css')}}" rel="stylesheet" />
		<!-- Fontawesome -->
		<link rel="stylesheet" href="{{asset('assets/sales/css/fontawesome.css')}}">
		<!-- icofont -->
		<link rel="stylesheet" href="{{asset('assets/sales/css/icofont.min.css')}}">
		<!-- Sidemenu Css -->
		<link href="{{asset('assets/sales/plugins/fullside-menu/css/dark-side-style.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/sales/plugins/fullside-menu/waves.min.css')}}" rel="stylesheet" />

		<link href="{{asset('assets/sales/css/plugin.css')}}" rel="stylesheet" />

		<link href="{{asset('assets/sales/css/jquery.tagit.css')}}" rel="stylesheet" />
    	<link rel="stylesheet" href="{{ asset('assets/sales/css/bootstrap-coloroicker.css') }}">
		<!-- Main Css -->
		<link rel="stylesheet" href="{{ asset('assets/vendor/css/select2.min.css') }}">
		<!-- stylesheet -->
		

		<link href="{{asset('assets/sales/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/sales/css/custom.css')}}" rel="stylesheet"/>
		<link href="{{asset('assets/sales/css/responsive.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/sales/css/common.css')}}" rel="stylesheet" />

		

		@yield('styles')

	</head>
	<body>
		<div class="page">
			<div class="page-main">
				<!-- Header Menu Area Start -->
				<div class="header">
					<div class="container-fluid">
						<div class="d-flex justify-content-between">
							<a class="admin-logo" href="{{ route('front.index') }}" target="_blank">
								<img src="{{asset('assets/images/'.$gs->logo)}}" alt="">
							</a>
							<div class="menu-toggle-button">
								<a class="nav-link" href="javascript:;" id="sidebarCollapse">
									<div class="my-toggl-icon">
											<span class="bar1"></span>
											<span class="bar2"></span>
											<span class="bar3"></span>
									</div>
								</a>
							</div>

							<div class="right-eliment">
								<ul class="list">

									

									<!-- <li class="bell-area">
										<a id="notf_conv" class="dropdown-toggle-1" target="_blank" href="{{ route('front.index') }}">
										<i class="fas fa-globe-americas"></i>
										</a>
									</li> -->
									<li class="bell-area">
										<a id="notf_conv" class="dropdown-toggle-1"  href="#" style="border: 1px solid;border-radius: 20px;">
											<i class="icofont-wallet"></i><i class="icofont-inr" aria-hidden="true"></i>{{number_format(Auth::guard('sales')->user()->commission,2)}}
										</a>
									</li>
									


									

									<li class="login-profile-area">
										<a class="dropdown-toggle-1" href="javascript:;">
											<div class="user-img">
												<img src="{{ Auth::guard('sales')->user()->photo ? asset('assets/images/salesperson/'.Auth::guard('sales')->user()->photo ):asset('assets/images/1567655174profile.jpg') }}" alt="">
											</div>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper">
												<ul>
													<h5>{{ __('Welcome!') }}</h5>
													<!-- <li>
														<a href="{{ route('sales.profile') }}"><i class="fas fa-user"></i> {{ __('Edit Profile') }}</a>
													</li> -->
													<li>
														<a href="{{ route('sales.logout') }}"><i class="fas fa-power-off"></i> {{ __('Logout') }}</a>
													</li>
												</ul>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- Header Menu Area End -->
				<div class="wrapper">
					<!-- Side Menu Area Start -->
					<nav id="sidebar" class="nav-sidebar">
						<ul class="list-unstyled components" id="accordion">
							<li>
								<a href="{{ route('sales.dashboard') }}" class="wave-effect"><i class="fa fa-home mr-2"></i>{{ __('Dashboard') }}</a>
							</li>
							
							@include('includes.sales.roles.super')
							

						</ul>
					
					</nav>
					<!-- Main Content Area Start -->
					@yield('content')
					<!-- Main Content Area End -->
					</div>
				</div>
			</div>

			@php
				$curr = \App\Models\Currency::where('is_default','=',1)->first();
			@endphp
			<script type="text/javascript">
			  var mainurl = "{{url('/')}}";
			  var admin_loader = {{ $gs->is_admin_loader }};
			  var whole_sell = {{ $gs->wholesell }};
			  var getattrUrl = '{{ route('admin-prod-getattributes') }}';
			  var curr = {!! json_encode($curr) !!};
				// console.log(curr);
			</script>

		<!-- Dashboard Core -->
		<script src="{{asset('assets/sales/js/vendors/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('assets/sales/js/vendors/vue.js')}}"></script>
		<script src="{{asset('assets/sales/js/vendors/bootstrap.min.js')}}"></script>
		<script src="{{asset('assets/sales/js/jqueryui.min.js')}}"></script>
		<!-- Fullside-menu Js-->
		<script src="{{asset('assets/sales/plugins/fullside-menu/jquery.slimscroll.min.js')}}"></script>
		<script src="{{asset('assets/sales/plugins/fullside-menu/waves.min.js')}}"></script>

		<script src="{{asset('assets/sales/js/plugin.js')}}"></script>
		<script src="{{asset('assets/sales/js/Chart.min.js')}}"></script>
		<script src="{{asset('assets/sales/js/tag-it.js')}}"></script>
		<script src="{{asset('assets/sales/js/nicEdit.js')}}"></script>
        <script src="{{asset('assets/sales/js/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{asset('assets/sales/js/notify.js') }}"></script>
        <script src="{{asset('assets/sales/js/jquery.canvasjs.min.js')}}"></script>
		
		<script src="{{asset('assets/sales/js/load.js')}}"></script>
		<script src="{{asset('assets/vendor/js/select2.min.js')}}"></script>
		<!-- Custom Js-->
		<script src="{{asset('assets/sales/js/custom.js')}}"></script>
		<!-- AJAX Js-->
		<script src="{{asset('assets/sales/js/myscript.js')}}"></script>
		<script>
			$(document).ready(function() {
				$('.js-example-basic-multiple').select2();
			});		
		</script>


		@yield('scripts')

@if($gs->is_admin_loader == 0)
<style>
	div#geniustable_processing {
		display: none !important;
	}
</style>
@endif

	</body>

</html>
