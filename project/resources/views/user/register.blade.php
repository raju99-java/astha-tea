@extends('layouts.front')

@section('content')
<section class="breadcrumbs">
  <div class="container">
      <div class="row">
          <div class="col-sm-12">
              <div class="breadcrumb-title-div">
                  <div class="bread-left-side">
                      <h2>Registration</h2>
                  </div>
                  <div class="breadcrumb-ul right-side">
                      <ul>
                      <li><a href="/">HOME</a>/</li>
                      <li><span>REGISTRATION</span></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<div class="total-content" id="content">
  <section class="login-div">
      <div class="container">
          <div class="row">
              <div class="col-sm-6 offset-sm-3">
                  <div class="login-box">
                      <div class="form-header">
                          <h4>Create An Account</h4>
                          <p>Enter your credentials to continue.</p>
                      </div> 
                        <form class="student-log-reg-form" action="{{route('user-register-submit')}}" method="POST" id="registerform">
                          {{ csrf_field() }}
                          @include('includes.admin.form-login')
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="form-group input-wrapper"> 
                                    <input type="text" class="form-control log" name="name" placeholder="{{ __('Full Name') }}" required="">
                                      <i class="fa fa-user"></i>
                                      <span class="help-block"></span>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="form-group input-wrapper"> 
                                    <input type="tel" class="form-control log" name="phone" placeholder="{{ __('Phone Number.') }}" required="">
                                      <i class="fa fa-phone"></i>
                                      <span class="help-block"></span>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="form-group input-wrapper"> 
                                  <input type="email" class="form-control log" name="email" placeholder="{{ __('Email Address (optional)') }}" >
                                      <i class="fa fa-envelope"></i>
                                      <span class="help-block"></span>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="text-center"> 
                                      <input type="submit" value="CONTINUE">
                                  </div>
                              </div>
                          </div>
                      </form>
                      <div class="form-footer">
                          </div>
                          <p>Already have an account? <a href="{{route('user.login')}}">Login</a></p>
                    </div>
                    </div>
              </div>
          </div>
      </div>
  </section>
</div>
<div class="modal bg-dark fade" id="signUp" tabindex="-1" role="dialog" aria-labelledby="signupmodal" aria-hidden="true"  data-backdrop="false" style="padding-left: 0px !important;">
		<div class="modal-dialog modal-xl signup-pop-form" role="document">
			<div class="modal-content overli" id="signUpmodales">
				<div class="modal-header">
					<div class="icon-boxes">
              <h3>Please Enter Your OTP</h3>
          </div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true"><i class="icofont-delete"></i></span>
					</button>
				</div>
				<div class="modal-body">
					<div class="login-form">
            <form class="student-log-reg-form modal-form mregisterform" action="{{ route('user.otpregister.submit') }}" method="POST" >
                {{ csrf_field() }}
                @include('includes.admin.form-login')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="resend-otp text-right">
                        <a href="javascript:void('0');" class="resend-otp-text" id="resend-login-otp" data-href="{{ route('user-resendotp-login') }}">RESEND OTP</a>
                        </div>
                        <div class="form-group input-wrapper">
                            <input type="text" class="form-control log" placeholder="Enter Your OTP*" name="otp" id="" >
                            <i class="fa fa-key"></i>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center"> 
                            <input type="submit" value="SUBMIT">
                        </div>
                    </div>
                </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


@endsection
@section('scripts')
<script>
    $("button[data-dismiss=modal]").click(function()
    {
    $(".modal").modal('hide');
    });
</script>
<script>
    function signUp() {
    $('.modal').modal('hide');
    $('#signUp').modal('show');
}
</script>
<script>
    $(document).ready(function(){
    $("#signUp").modal({
    show:false,
    backdrop:'static'
    });
    });
</script>
@endsection