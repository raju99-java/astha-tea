<!doctype html>
<html lang="en" dir="ltr">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="author" content="GeniusOcean">
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
    <link href="{{asset('assets/sales/css/style.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/sales/css/custom.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/sales/css/responsive.css')}}" rel="stylesheet" />
    @yield('styles')

  </head>
  <body>

    <!-- Login and Sign up Area Start -->
    <section class="login-signup">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="login-area">
              <div class="header-area">
                <h4 class="title">{{ __('Login Now') }}</h4>
                <p class="text">{{ __('Welcome back, please sign in below') }}</p>
              </div>
              <div class="login-form">
                @include('includes.sales.form-login')
                <form id="loginform" action="{{ route('sales.login.submit') }}" method="POST">
                  {{ csrf_field() }}
                  <div class="form-input">
                    <input type="tel" name="phone" class="User Name" placeholder="{{ __('Type Phone Number') }}" value=""  autofocus>
                    <i class="icofont-user-alt-5"></i>
                  </div>
                  <div class="form-input">
                    <input type="password" name="password" class="Password" placeholder="{{ __('Type Password') }}">
                    <i class="icofont-ui-password"></i>
                  </div>
                 
                  <input id="authdata" type="hidden"  value="{{ __('Authenticating...') }}">
                  <button class="submit-btn">{{ __('Login') }}</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Login and Sign up Area End -->


    <!-- Dashboard Core -->
    <script src="{{asset('assets/sales/js/vendors/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('assets/sales/js/vendors/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/sales/js/jqueryui.min.js')}}"></script>
    <!-- Fullside-menu Js-->
    <script src="{{asset('assets/sales/plugins/fullside-menu/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/sales/plugins/fullside-menu/waves.min.js')}}"></script>

    <script src="{{asset('assets/sales/js/plugin.js')}}"></script>
    <script src="{{asset('assets/sales/js/tag-it.js')}}"></script>
    <script src="{{asset('assets/sales/js/nicEdit.js')}}"></script>
    <script src="{{ asset('assets/sales/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{asset('assets/sales/js/load.js')}}"></script>
    <!-- Custom Js-->
    <script src="{{asset('assets/sales/js/custom.js')}}"></script>
    <!-- AJAX Js-->
    <script src="{{asset('assets/sales/js/myscript.js')}}"></script>

  </body>

</html>