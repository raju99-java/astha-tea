<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(isset($page->meta_tag) && isset($page->meta_description))
        <meta name="keywords" content="{{ $page->meta_tag }}">
        <meta name="description" content="{{ $page->meta_description }}">
		<title>{{$gs->title}}</title>
    @elseif(isset($blog->meta_tag) && isset($blog->meta_description))
        <meta name="keywords" content="{{ $blog->meta_tag }}">
        <meta name="description" content="{{ $blog->meta_description }}">
		<title>{{$gs->title}}</title>
    @elseif(isset($productt))
		<meta name="keywords" content="{{ !empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): '' }}">
		<meta name="description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}">
	    <meta property="og:title" content="{{$productt->name}}" />
	    <meta property="og:description" content="{{ $productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description) }}" />
	    <meta property="og:image" content="{{asset('assets/images/thumbnails/'.$productt->thumbnail)}}" />
	    <meta name="author" content="GeniusOcean">
    	<title>{{substr($productt->name, 0,11)."-"}}{{$gs->title}}</title>
    @else
	    <meta name="keywords" content="{{ $seo->meta_keys }}">
	    <meta name="author" content="GeniusOcean">
		<title>{{$gs->title}}</title>
    @endif
	 <!------------Website Theme Color------------------>
    <!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#4C9A2A">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#4C9A2A">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#4C9A2A">
    <!------------//end Theme Color----------------->
	<!-- favicon -->
	<link rel="icon"  type="image/x-icon" href="{{asset('assets/images/'.$gs->favicon)}}"/>



	<link rel="stylesheet" href="{{asset('assets/front/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/jquery.fancybox.min.css')}}">
	<!-- <link rel="stylesheet" href="{{asset('assets/front/css/owl.carousel.min.css')}}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
	<link rel="stylesheet" href="{{asset('assets/front/css/slick.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/slick-theme.css')}}">

	<link rel="stylesheet" href="{{asset('assets/front/css/toastr.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/stylesheet.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/responsive.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/engo-customize.scss.css')}}">
	<!--fontawesome-->
    <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('assets/front/css/icofont.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/icofont.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/Cormorant Upright.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/Be Vietnam Pro.css')}}">

	@yield('styles')
	

	<style>
		.wdfp{
			background: red;
		}
		.lazy{
			background-color: rgb(243 240 238);
			display: block;
		}
	</style>

	<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/styles.php?color='.str_replace('#','',$gs->colors).'&'.'header_color='.str_replace('#','',$gs->header_color).'&'.'footer_color='.str_replace('#','',$gs->footer_color).'&'.'copyright_color='.str_replace('#','',$gs->copyright_color).'&'.'menu_color='.str_replace('#','',$gs->menu_color).'&'.'menu_hover_color='.str_replace('#','',$gs->menu_hover_color)) }}"> -->


</head>

<body>

@if($gs->is_loader == 1)
    @if(url()->current() == route('front.index'))
	@else
	<div class="preloader" id="preloader" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center #FFF;"></div>
    @endif
@endif
	<div class="xloader d-none" id="xloader" style="background: url({{asset('assets/front/images/xloading.gif')}}) no-repeat scroll center center #FFF;"></div>


	<div class="wrapper">
        <!--back-to-top  -->
        <a id="back2Top" title="Back to top" href="#"><i class="fa fa-chevron-up backss" aria-hidden="true"></i></a>
        <!-----------------------------------------------------header---------------------------------------------->
        <div class="super_container">
          <!-- Header -->
          <header class="header">
              <!-- Top Bar -->
			<div class="top_bar">
                <div class="container">
                    <div class="row">
                        <div class="col d-flex flex-row">
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><i class="fa fa-phone"></i></div>{{$ps->phone}}
                            </div>
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><i class="fa fa-envelope-o"></i></div><a href="mailto:{{$ps->email}}">{{$ps->email}}</a>
                            </div>
                            <div class="top_bar_content ml-auto">
                                <div class="top_bar_user">
                                    <div class="user_icon"><i class="fa fa-user"></i></div>
                                    @if(Auth::guard('web')->check())
                                    <div><a href="{{ route('user-dashboard') }}">Dashboard</a></div>
                                    @else
                                    <div><a href="{{ route('user.register') }}">Register</a></div>
                                    <div><a href="{{ route('user.login') }}">Sign in</a></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
			  <!-- Header Main -->
              <div class="header_main">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Logo -->
                        <div class="col-lg-2 col-sm-3 col-3 order-2">
                            <div class="logo_container">
                                <div class="logo"><a href="{{route('front.index')}}"><img src="{{asset('assets/images/'.$gs->logo)}}" class="img-fluid"></a></div>
                            </div>
                        </div> <!-- Search -->
                        <div class="col-lg-4 col-12 order-lg-2 order-3 text-lg-left text-right">
                            <div class="header_search">
                                <div class="header_search_content">
                                    <div class="header_search_form_container">
										<form id="searchForm" class="header_search_form clearfix" action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}" method="GET">
											@if (!empty(request()->input('sort')))
											<input type="hidden" name="sort" value="{{ request()->input('sort') }}">
											@endif
											@if (!empty(request()->input('minprice')))
												<input type="hidden" name="minprice" value="{{ request()->input('minprice') }}">
											@endif
											@if (!empty(request()->input('maxprice')))
												<input type="hidden" name="maxprice" value="{{ request()->input('maxprice') }}">
											@endif	
											<input type="search" class="header_search_input" id="prod_name" name="search" placeholder="{{ __('Search For Product...') }}" value="{{ request()->input('search') }}" autocomplete="off">
											<div class="custom_dropdown" style="display: none;">
												<div class="custom_dropdown_list"> <span class="custom_dropdown_placeholder clc">All Categories</span> <i class="fas fa-chevron-down"></i>
													<ul class="custom_list clc">
														<li><a class="clc" href="#">All Categories</a></li>
														
													</ul>
												</div>
											</div> 
											<button type="submit" class="header_search_button trans_300" value="Submit"><img src="{{asset('assets/front/images/search.png')}}" alt=""></button>
										</form>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <!-- main-menu -->
                        <div class="col-lg-5 col-5 order-lg-2 order-1 text-lg-left text-right">
                              <nav class="main_nav">
                                  <div class="container">
                                      <div class="row">
                                          <div class="col">
                                              <div class="main_nav_content d-flex flex-row justify-content-center">
                                                  <!-- Categories Menu -->
                                                  <!-- Main Nav Menu -->
                                                  <div class="main_nav_menu">
                                                      <ul class="standard_dropdown main_nav_dropdown">
                                                          <li><a href="{{route('front.index')}}">Home</a></li>
                                                          <li><a href="{{route('front.about')}}">About Us</a></li>
                                                          <li class="hassubs">
                                                            <a href="{{route('front.category')}}">Shop<i class="fas fa-chevron-down"></i></a>
                                                            <ul>
                                                                @foreach($categories as $data)
                                                                <li><a href="{{ route('front.category',$data->slug) }}">{{ $data->name }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                          <li><a href="{{route('front.customtea')}}">Custom Tea</a></li>
                                                          <li><a href="{{route('front.contact')}}">Contact Us</a></li>
                                                      </ul>
                                                  </div> <!-- Menu Trigger -->
                                                  <div class="menu_trigger_container ml-auto">
                                                      <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                                          <div class="menu_burger">
                                                              <div class="menu_trigger_text">menu</div>
                                                              <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </nav> 
                          </div>
                          <div class="col-lg-1 col-4 order-lg-3 order-2 text-lg-left text-right">
                              <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                                      <div class="wishlist_icon mr-2 d-lg-none">
                                        <a class="cart-icon" href="{{ route('user.login') }}">
                                            <i class="fa fa-user custom-i"></i>
                                        </a>
                                    </div>
                                    <div class="wishlist_icon">
                                        <a class="cart-icon" href="{{ route('user-wishlists') }}">
                                            <i class="fa fa-heart custom-i"></i><span class="cart_count wishlist" id="wishlist-count">@if(Auth::guard('web')->check())
													{{ Auth::user()->wishlistCount() }}
													@else
													0
													@endif</span>
                                        </a>
                                    </div>
                                    <!-- Cart -->
                                  <div class="cart">
                                      <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                          <div class="cart_icon"> 
                                              <a class="cart-icon" href="{{route('front.cart')}}">
                                                  <i class="icofont-cart custom-i"></i><span class="cart_count wishlist" id="cart-count">{{ Session::has('cart') ? count(Session::get('cart')->items) : '0' }}</span>
                                              </a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        <!-- Wishlist -->
                        
                    </div>
                </div>
            </div> 
			  
            <!-- Menu -->
            <div class="page_menu">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="page_menu_content">
                                <div class="page_menu_search">
									<form  action="{{ route('front.category', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')]) }}"> 
										<input type="search" class="page_menu_search_input" id="prod_names" name="search" placeholder="{{ __('Search For Product...') }}" value="{{ request()->input('search') }}" autocomplete="off">
										<!-- <input type="search" required="required" class="page_menu_search_input" placeholder="Search for products..."> -->
                                        <button type="submit" class="header_search_button trans_300" value="Submit"><img src="{{asset('assets/front/images/search.png')}}" alt=""></button> 
                                    </form>
                                </div>
                                <ul class="page_menu_nav">
                                    <li class="page_menu_item"> <a href="{{route('front.index')}}">Home</a> </li>
                                    <li class="page_menu_item"> <a href="{{route('front.index')}}">About Us</a> </li>
                                    <!-- <li class="page_menu_item"><a href="{{route('front.category')}}">Shop</a></li> -->
                                    <div class="btn-group">
                                    <li class="page_menu_item"><a href="{{route('front.category')}}">Shop</a></li>
                                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>                                       
                                        <div class="dropdown-menu">
                                            @foreach($categories as $data)
                                            <li><a href="{{ route('front.category',$data->slug) }}">{{ $data->name }}</a></li>
                                            @endforeach
                                        </div>
                                    </div>
                                   
                                    <li class="page_menu_item"><a href="{{route('front.customtea')}}">Custom Tea</a></li>
                                    <li class="page_menu_item"><a href="{{route('front.contact')}}">Contact Us</a></li>
                                </ul>
                                <div class="menu_contact">
                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon"><i class="fa fa-phone" style="color: #fff;"></i></div><a href="mailto:{{$ps->phone}}">{{$ps->phone}}</a>
                                    </div>
                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon"><i class="fa fa-envelope-o" style="color: #fff;"></i></div><a href="mailto:{{$ps->email}}">{{$ps->email}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>
      </div>
        <!--------------------------------------------------///header---------------------------------------------->
        @yield('content')


            <!-------------------------------------------------footer----------------------------->
                <section class="footer gapping-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                                <div class="footer-widget">
                                    <div class="footer-logo">
                                        <img src="{{asset('assets/images/'.$gs->footer_logo)}}" class="img-fluid">
                                    </div>
                                    <div class="footer-content">
                                        <p>
                                        {!! $gs->footer !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 col-md-3">
                                <div class="footer-widget">
                                    <div class="footer-heading"><h3>contact us</h3></div>
                                    <div class="contact-contents">
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <a href="tel:{{$ps->phone}}"><i class="mr-2 fa fa-phone-square "></i>{{$ps->phone}}</a>
                                            </li>
                                            <li><a href="mailto:{{$ps->email}}"><i class=" mr-2 fa fa-envelope "></i>{{$ps->email}}</a></li>
                                            <li><a href="/" ><i class="mr-2 fa fa-map-pin"></i>{!! $ps->street !!}</a></li>
                                        </ul>
                                        <div class="mt-3">
                                            <ul class="list-inline list-unstyled mb-0">
												@if($socialsetting->f_status == 1)
												
												<li class="list-inline-item">
													<a href="{{ $socialsetting->facebook }}" class="facebook" target="_blank">
														<i class="fab fa-facebook-f"></i>
													</a>
												</li>
												@endif

												@if($socialsetting->g_status == 1)
												<li class="list-inline-item">
													<a href="{{ $socialsetting->gplus }}" class="google-plus" target="_blank">
														<i class="fab fa-google-plus-g"></i>
													</a>
												</li>
												@endif

												@if($socialsetting->t_status == 1)
												<li class="list-inline-item">
													<a href="{{ $socialsetting->twitter }}" class="twitter" target="_blank">
														<i class="fab fa-twitter"></i>
													</a>
												</li>
												@endif

												@if($socialsetting->l_status == 1)
												<li class="list-inline-item">
													<a href="{{ $socialsetting->linkedin }}" class="linkedin" target="_blank">
														<i class="fab fa-linkedin-in"></i>
													</a>
												</li>
												@endif

												@if($socialsetting->d_status == 1)
												<li class="list-inline-item">
													<a href="{{ $socialsetting->dribble }}" class="dribbble" target="_blank">
														<i class="fab fa-dribbble"></i>
													</a>
												</li>
												@endif
												
												@if($socialsetting->i_status == 1)
												<li class="list-inline-item">
													<a href="{{ $socialsetting->instagram }}" class="instagram" target="_blank">
														<i class="fab fa-instagram"></i>
													</a>
												</li>
												@endif
                                               
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="footer-widget">
                                    <div class="footer-heading"><h3>categories</h3></div>
                                    <div class="footer-ul">
                                        <ul class="list-unstyled mb-0">
                                            @foreach($categories as $data)
                                            <li><a href="{{ route('front.category',$data->slug) }}">{{$data->name}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>   
                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="footer-widget">
                                    <div class="footer-heading"><h3>useful links</h3></div>
                                    <div class="footer-ul">
                                        <ul class="list-unstyled mb-0">
                                            <li><a href="{{route('front.index')}}">Home</a></li>
                                            <li><a href="{{route('front.about')}}">About Us</a></li>
                                            <li><a href="{{route('front.contact')}}">Contact Us</a></li>
                                            @foreach(DB::table('pages')->where('footer','=',1)->get() as $data)
                                                <li>
                                                    <a href="{{ route('front.page',$data->slug) }}">
                                                        {{ $data->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2 col-md-2">
                                <div class="footer-widget">
                                    <div class="footer-heading"><h3>your account</h3></div>
                                    <div class="footer-ul">
                                        <ul class="list-unstyled mb-0">
                                            <li><a href="{{ route('user-dashboard') }}">My Account</a></li>
                                            <li><a href="{{ route('user-wishlists') }}">Wishlist</a></li>
                                            <li><a href="{{ route('front.cart') }}">My Cart</a></li>
                                            <li><a href="{{ route('user-orders') }}">My Orders</a></li>
                                            <li><a href="{{ route('user-customtea-orders') }}">My Custom Tea Orders</a></li>
                                        </ul> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- copyright -->
                <section class="copy-right">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="copy-content">
                                    <p>{!! $gs->copyright !!}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                               <div class="payment-gatways">
                                   <img src="{{asset('assets/front/images/product-payment.png')}}" class="img-fluid">
                               </div> 
                            </div>
                        </div>
                    </div>
                </section>
            <!-----------------------------------------------//footer---------------------------->

            </div>
        <!-------------//contents--------------->
    <!--wrapper-->
    </div>






<!-- Product Quick View Modal -->

	  <div class="modal fade" id="quickview" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog quickview-modal modal-dialog-centered modal-lg" role="document">
		  <div class="modal-content">
			<div class="submit-loader">
				<img class="lazy" data-src="{{asset('assets/images/'.$gs->loader)}}" alt="">
			</div>
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<div class="container quick-view-modal">

				</div>
			</div>
		  </div>
		</div>
	  </div>
<!-- Product Quick View Modal -->

<!-- Order Tracking modal Start-->
    <div class="modal fade" id="track-order-modal" tabindex="-1" role="dialog" aria-labelledby="order-tracking-modal" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"> <b><i class="fas fa-truck"></i>{{ __('Order Tracking') }}</b> </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                        <div class="order-tracking-content">
                            <form id="track-form" class="track-form">
                                {{ csrf_field() }}
                                <input type="text" id="track-code" placeholder="{{ __('Get Tracking Code') }}" required="">
                                <button type="submit" class="mybtn1">{{ __('View Tracking') }}</button>
                                <a href="#"  data-toggle="modal" data-target="#order-tracking-modal"></a>
                            </form>
                        </div>

                        <div>
				            <div class="submit-loader d-none">
								<img class="lazy" data-src="{{asset('assets/images/'.$gs->loader)}}" alt="">
							</div>
							<div id="track-order">

							</div>
                        </div>

            </div>
            </div>
        </div>
    </div>
<!-- Order Tracking modal End -->


 
@php
	$lang_file = $data_results = file_get_contents(resource_path().'/lang/'.$langg->file);
@endphp

<script type="text/javascript">
  var mainurl = "{{url('/')}}";
  var gs      = {!! json_encode(\App\Models\Generalsetting::first()->makeHidden(['stripe_key', 'stripe_secret', 'smtp_pass', 'instamojo_key', 'instamojo_token', 'paystack_key', 'paystack_email', 'paypal_business', 'paytm_merchant', 'paytm_secret', 'paytm_website', 'paytm_industry', 'paytm_mode', 'molly_key', 'razorpay_key', 'razorpay_secret'])) !!};
  var langg    = {
	"add_cart": "{{__('Successfully Added To Cart')}}",
    "already_cart": "{{__('Already Added To Cart')}}",
    "out_stock": "{{__('Out Of Stock')}}",
    "add_wish": "{{__('Successfully Added To Wishlist')}}",
    "already_wish": "{{__('Already Added To Wishlist')}}",
    "wish_remove": "{{__('Successfully Removed From The Wishlist')}}",
    "add_compare": "{{__('Successfully Added To Compare')}}",
    "already_compare": "{{__('Already Added To Compare')}}",
    "compare_remove": "{{__('Successfully Removed From The Compare')}}",
    "color_change": "{{__('Successfully Changed The Color')}}",
    "coupon_found": "{{__('Coupon Found')}}",
    "no_coupon": "{{__('No Coupon Found')}}",
    "already_coupon": "{{__('Coupon Already Applied')}}",
    "email_not_found": "{{__('Email Not Found')}}",
    "something_wrong": "{{__('Oops Something Goes Wrong !!')}}",
    "message_sent": "{{__('Message Sent !!')}}",
    "order_title": "{{__('THANK YOU FOR YOUR PURCHASE.')}}",
    "order_text": "{{__("We'll email you an order confirmation with details and tracking info.")}}",
    "subscribe_success": "{{__('You have subscribed successfully.')}}",
    "subscribe_error": "{{__('This email has already been taken.')}}",
  };



</script>

	<!-- jquery -->
	
	<script src="{{asset('assets/front/js/jquery.js')}}"></script>
	<script src="{{asset('assets/front/js/vue.js')}}"></script>
	<script src="{{asset('assets/front/jquery-ui/jquery-ui.min.js')}}"></script>
	<!-- popper -->
	<script src="{{asset('assets/front/js/popper.min.js')}}"></script>
	<!-- bootstrap -->
	<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
	<!-- plugin js-->
	<script src="{{asset('assets/front/js/jquery.fancybox.min.js')}}"></script>

	<!-- <script src="{{asset('assets/front/js/owl.carousel.js')}}"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
	<script src="{{asset('assets/front/js/slick.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
	<script src="{{asset('assets/front/js/xzoom.min.js')}}"></script>
	<script src="{{asset('assets/front/js/jquery.hammer.min.js')}}"></script>
	<script src="{{asset('assets/front/js/setup.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/front/js/lazy.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/front/js/lazy.plugin.js')}}"></script>
	
	<script src="{{asset('assets/front/js/toastr.js')}}"></script>
	<!-- main -->
	<script src="{{asset('assets/front/js/main.js')}}"></script>
	<!-- custom -->
	<script src="{{asset('assets/front/js/custom.js')}}"></script>
	<script src="{{asset('assets/front/js/cross-sell.js')}}"></script>


	<script>
		
	
		$(window).on('load',function() {
		setTimeout(function(){
			$('.categories_menu_inner').load('{{route('front.get.category')}}');
		}, 500);

        });
	
		function lazy (){
			$(".lazy").Lazy({
				scrollDirection: 'vertical',
				effect: "fadeIn",
				effectTime:1000,
				threshold: 0,
				visibleOnly: false,  
				onError: function(element) {
					console.log('error loading ' + element.data('src'));
				}
			});
		}

		function lazyCross (){
			$(".lazy-cross").Lazy({
				scrollDirection: 'horizontal',
				effect: "fadeIn",
				effectTime:1000,
				threshold: 0,
				visibleOnly: false,  
				onError: function(element) {
					console.log('error loading ' + element.data('src'));
				}
			});
		}

		
		lazy();
	</script>
	<script>
        $(window).scroll(function() {
        var height = $(window).scrollTop();
        if (height > 100) {
        $('#back2Top').fadeIn();
        } else {
        $('#back2Top').fadeOut();
        }
        });
        $(document).ready(function() {
        $("#back2Top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
        });
        });
    </script>
    <!-- slider -->
    <script>
      jQuery(document).ready(function($) {
      
        $('.slick-side-h1').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: false,
          dots: true,
          arrows: false,
          fade : true,
          adaptiveHeight: true,
          prevArrow:'<button type="button" class="prev-slide"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.787 490.787" style="enable-background:new 0 0 490.787 490.787;" xml:space="preserve"> <path style="fill:#F44336;" d="M362.671,490.787c-2.831,0.005-5.548-1.115-7.552-3.115L120.452,253.006 c-4.164-4.165-4.164-10.917,0-15.083L355.119,3.256c4.093-4.237,10.845-4.354,15.083-0.262c4.237,4.093,4.354,10.845,0.262,15.083 c-0.086,0.089-0.173,0.176-0.262,0.262L143.087,245.454l227.136,227.115c4.171,4.16,4.179,10.914,0.019,15.085 C368.236,489.664,365.511,490.792,362.671,490.787z"/> <path d="M362.671,490.787c-2.831,0.005-5.548-1.115-7.552-3.115L120.452,253.006c-4.164-4.165-4.164-10.917,0-15.083L355.119,3.256 c4.093-4.237,10.845-4.354,15.083-0.262c4.237,4.093,4.354,10.845,0.262,15.083c-0.086,0.089-0.173,0.176-0.262,0.262 L143.087,245.454l227.136,227.115c4.171,4.16,4.179,10.914,0.019,15.085C368.236,489.664,365.511,490.792,362.671,490.787z"/> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg></button>',
          nextArrow:'<button type="button" class="next-slide"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.8 490.8" style="enable-background:new 0 0 490.8 490.8;" xml:space="preserve"> <path style="fill:#F44336;" d="M135.685,3.128c-4.237-4.093-10.99-3.975-15.083,0.262c-3.992,4.134-3.992,10.687,0,14.82 l227.115,227.136L120.581,472.461c-4.237,4.093-4.354,10.845-0.262,15.083c4.093,4.237,10.845,4.354,15.083,0.262 c0.089-0.086,0.176-0.173,0.262-0.262l234.667-234.667c4.164-4.165,4.164-10.917,0-15.083L135.685,3.128z"/> <path d="M128.133,490.68c-5.891,0.011-10.675-4.757-10.686-10.648c-0.005-2.84,1.123-5.565,3.134-7.571l227.136-227.115 L120.581,18.232c-4.171-4.171-4.171-10.933,0-15.104c4.171-4.171,10.933-4.171,15.104,0l234.667,234.667 c4.164,4.165,4.164,10.917,0,15.083L135.685,487.544C133.685,489.551,130.967,490.68,128.133,490.68z"/> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg></button>', 
          responsive: [
    
            {
              breakpoint: 1200,
              settings: {
                infinite: true,
                dots: true ,
                arrows: false
              }
            },
            {
              breakpoint: 1024,
              settings: {
                dots: true ,
                arrows: false
              }
            },
            {
              breakpoint:600,
              settings: {
                dots: true ,
                arrows: false,
              }
            }
          ]
        });
        })
    </script>
    <script>
      $(document).ready(function()
{
"use strict";

var menuActive = false;
var header = $('.header');
setHeader();
initCustomDropdown();
initPageMenu();

function setHeader()
{

if(window.innerWidth > 991 && menuActive)
{
closeMenu();
}
}

function initCustomDropdown()
{
if($('.custom_dropdown_placeholder').length && $('.custom_list').length)
{
var placeholder = $('.custom_dropdown_placeholder');
var list = $('.custom_list');
}

placeholder.on('click', function (ev)
{
if(list.hasClass('active'))
{
list.removeClass('active');
}
else
{
list.addClass('active');
}

$(document).one('click', function closeForm(e)
{
if($(e.target).hasClass('clc'))
{
$(document).one('click', closeForm);
}
else
{
list.removeClass('active');
}
});

});

$('.custom_list a').on('click', function (ev)
{
ev.preventDefault();
var index = $(this).parent().index();

placeholder.text( $(this).text() ).css('opacity', '1');

if(list.hasClass('active'))
{
list.removeClass('active');
}
else
{
list.addClass('active');
}
});


$('select').on('change', function (e)
{
placeholder.text(this.value);

$(this).animate({width: placeholder.width() + 'px' });
});
}

/*

4. Init Page Menu

*/

function initPageMenu()
{
if($('.page_menu').length && $('.page_menu_content').length)
{
var menu = $('.page_menu');
var menuContent = $('.page_menu_content');
var menuTrigger = $('.menu_trigger');

//Open / close page menu
menuTrigger.on('click', function()
{
if(!menuActive)
{
openMenu();
}
else
{
closeMenu();
}
});

//Handle page menu
if($('.page_menu_item').length)
{
var items = $('.page_menu_item');
items.each(function()
{
var item = $(this);
if(item.hasClass("has-children"))
{
item.on('click', function(evt)
{
evt.preventDefault();
evt.stopPropagation();
var subItem = item.find('> ul');
if(subItem.hasClass('active'))
{
subItem.toggleClass('active');
TweenMax.to(subItem, 0.3, {height:0});
}
else
{
subItem.toggleClass('active');
TweenMax.set(subItem, {height:"auto"});
TweenMax.from(subItem, 0.3, {height:0});
}
});
}
});
}
}
}

function openMenu()
{
var menu = $('.page_menu');
var menuContent = $('.page_menu_content');
TweenMax.set(menuContent, {height:"100%"});
TweenMax.from(menuContent, 0.3, {x:-135, y:0});
menuActive = true;
}

function closeMenu()
{
var menu = $('.page_menu');
var menuContent = $('.page_menu_content');
TweenMax.to(menuContent, 0.5, {height:"0"});
// TweenMax.from(menuContent, 0.5, {x:135, y:0});
menuActive = false;
}


});
</script>

<script>
  jQuery(document).ready(function($) {
    $(".news-slider").owlCarousel({
        items : 4,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:true
    });
});
</script>
<script>
  jQuery(document).ready(function($) {
    $(".others-product").owlCarousel({
        items : 4,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:true
    });
});
</script>
<script>
  jQuery(document).ready(function($) {
    $(".testimonial").owlCarousel({
        items : 3,
        itemsDesktop:[1199,3],
        itemsDesktopSmall:[980,2],
        itemsMobile : [600,1],
        navigation:true,
        navigationText:["",""],
        pagination:true,
        autoPlay:true
    });
});
</script>


    {!! $seo->google_analytics !!}

	@if($gs->is_talkto == 1)
		<!--Start of Tawk.to Script-->
		{!! $gs->talkto !!}
		<!--End of Tawk.to Script-->
	@endif

	@yield('scripts')

</body>

</html>
