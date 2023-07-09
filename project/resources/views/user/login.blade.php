@extends('layouts.front')

@section('content')
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-title-div">
                    <div class="bread-left-side">
                        <h2>Login</h2>
                    </div>
                    <div class="breadcrumb-ul right-side">
                        <ul>
                        <li><a href="/">HOME</a>/</li>
                        <li><span>LOGIN</span></li>
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
                            <h4>Welcome Back</h4>
                            <p>Enter your credentials to continue.</p>
                        </div> 
                        <form class="student-log-reg-form" action="{{ route('user.login.submit') }}" method="POST" id="loginform">
                        {{ csrf_field() }}
                        @include('includes.admin.form-login')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group input-wrapper"> 
                                        <input type="tel" class="form-control log" placeholder="Enter Your Mobile Number*" name="phone" id="" required="">
                                        <i class="fa fa-mobile"></i>
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
                            <input type="hidden" name="modal" value="logIn">
                        <input class="mauthdata" type="hidden" value="{{ __('Authenticating...') }}">
                        </form>
                        <div class="form-footer">
                            <p>Don't have account? <a href="{{ route('user.register') }}">Register</a></p>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal bg-dark fade" id="logIn" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true"  data-backdrop="false" style="padding-left: 0px !important;">
		<div class="modal-dialog modal-xl login-pop-form" role="document">
			<div class="modal-content overli" id="logInmodales">
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
                    <form class="student-log-reg-form modal-form mloginform" action="{{ route('user.otplogin.submit') }}" method="POST" >
                        {{ csrf_field() }}
                        @include('includes.admin.form-login')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="resend-otp text-right">
                                        <a href="javascript:void('0');" class="resend-otp-text" id="resend-login-otp" data-href="{{ route('user-resendotp-register') }}">RESEND OTP</a>
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
    function login() {
    $('.modal').modal('hide');
    $('#logIn').modal('show');
}
</script>
<script>
    $(document).ready(function(){
    $("#logIn").modal({
    show:false,
    backdrop:'static'
    });
    });
</script>
@endsection