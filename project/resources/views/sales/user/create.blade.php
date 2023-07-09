@extends('layouts.sales')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet" />
<style>
    /*********modal css********/
#logInmodales, .signUpmodales{
    background: #ffffff;
    margin-top: 6rem;
}
.modal-title{
    margin-top: 10px;
    margin-bottom: 25px;
    text-transform: capitalize;
    font-size: 30px;
    color: #4c9a2a;
    text-align: center;
    font-family: system-ui;
    font-weight: 600;
    line-height: 20px;
    font-style: normal;
    position: relative;
}
.modal-title::after {
    content: '';
    bottom: -15px;
    position: absolute;
    display: block;
    width: 50px;
    height: 3px;
    background: #4c9a2a;
}
.log {
    display: block;
    width: 100%;
    padding: 7px 2px;
    margin-bottom: 7px;
    border-bottom: 1px solid gray;
    background: rgba(0, 0, 0, 0.05);
    color: #000;
    font-size: 16px;
    border-radius: 50px;
    border: 1px solid transparent;
    padding-left: 20px;
    padding-right: 20px;
    font-size: 16px;
}
.input-wrapper i {
    color: #4c9a2a;
    position: absolute;
    right: 13px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 25px;
}
.resend-otp-text {
    line-height: 35px;
    font-size: 12px;
    color: #4c9a2a;
    font-weight: 600;
}
.close {
    color: #4c9a2a;
    font-size: 30px;
    font-weight: 900;
    opacity: inherit;
}
.close:not(:disabled):not(.disabled):focus, .close:not(:disabled):not(.disabled):hover {
    border: none !important;
    outline: none !important;
}
.student-log-reg-form [type=submit] {
    border-radius: 50px;
    padding: 0 30px;
    height: 41px;
    letter-spacing: 1px;
    text-transform: uppercase;
    background-color: #4c9a2a;
    color: #fff;
    border: 0px;
    width: 100%;
    cursor: pointer;
}
</style>
@endsection
@section('content')

<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Customer') }} 
				</h4>
				<ul class="links">
					<li>
						<a href="{{ route('sales.dashboard') }}">{{ __('Dashboard') }} </a>
					</li>
					<li>
						<a href="javascript:;">{{ __('Customer') }} </a>
					</li>
					<li>
						<a href="{{ route('sales-user-create') }}">{{ __('Add Customer') }}</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>

	<form id="geniusform" action="{{route('sales-user-store')}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}	
	<div class="row">
		<div class="col-lg-10">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">
		
								<div class="gocover"
									style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
								</div>
		
									@include('includes.sales.form-both')
									<!-- <div class="row">
										<div class="col-lg-4">
										<div class="left-area">
											<h4 class="heading">{{ __("User Profile Image") }} *</h4>
										</div>
										</div>
										<div class="col-lg-7">
										<div class="img-upload">
											<div id="image-preview" class="img-preview" style="background: url({{ asset('assets/images/noimage.png') }});">
												<label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __("Upload Image") }}</label>
												<input type="file" name="photo" class="img-upload" id="image-upload">
											</div>
											<p class="text">{{ __("Prefered Size: (600x600) or Square Sized Image") }}</p>
										</div>
										</div>
									</div> -->
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('User Type') }}* </h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select name="user_type" required="">
												<!-- <option value="">Select User Type</option> -->
												<option value="domestic">Domestic</option>
												<option value="commercial">Commercial</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Full Name') }}* </h4>
												<p class="sub-heading">{{ __('(In Any Language)') }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="{{ __('Enter Full Name') }}"
												name="name">
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Address') }}* </h4>
											</div>
										</div>
										<div class="col-lg-12">
										<textarea name="address" class="input-field"
													placeholder="{{ __('Enter Address') }}"></textarea>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Email') }}</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="email" type="email" class="input-field"
												placeholder="{{ __('Enter Email') }}">
											
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Phone Number') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="phone" type="tel" class="input-field"
												placeholder="{{ __('Enter Phone Number') }}">
											
										</div>
									</div>
									
									
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Family member count') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="family_member" type="text" class="input-field"
												placeholder="{{ __('Enter Total family Member') }}">
											
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Currently using tea brand') }}*</h4>
												
											</div>
										</div>
										<div class="col-lg-12">
											<input name="currently_using_tea_brand" type="text" class="input-field"
												placeholder="{{ __('Enter Currently using tea brand') }}">
											
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Monthly consuming tea weight') }}*</h4>
												<p class="sub-heading">{{ __('(In Grams)') }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="monthly_consuming_tea_weight" type="text" class="input-field"
												placeholder="{{ __('Enter Monthly consuming tea weight') }}">
											
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Monthly tea cost') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="monthly_tea_cost" type="text" class="input-field"
												placeholder="{{ __('Enter Monthly tea cost') }}">
											
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Tea Type') }}* </h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select name="tea_type" required="">
												<!-- <option value="">Select Tea Type</option> -->
												<option value="Leaf Tea">Leaf Tea</option>
												<option value="CTC Tea">CTC Tea</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Preferred Time To Receive Call From Our Tea Expert') }}* </h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select required="" name="preferred_time_to_receive_call_from_our_tea_expert" >
												<option value="">{{ __('Select Preferred Time To Receive Call From Our Tea Expert') }}</option>
												<option value="10:00 am - 12:00 pm">10:00 am - 12:00 pm</option>
												<option value="12:00 pm - 2:00 pm" >12:00 pm - 2:00 pm</option>
												<option value="2:00 pm - 4:00 pm">2:00 pm - 4:00 pm</option>
												<option value="4:00 pm - 6:00 pm"  >4:00 pm - 6:00 pm</option>
												<option value="6:00 pm - 8:00 pm"  >6:00 pm - 8:00 pm</option>
												<option value="8:00 pm - 10:00 pm" >8:00 pm - 10:00 pm</option>
											</select>
										</div>
									</div>
									
									<!-- <div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Password') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="password" type="password" class="input-field"
												placeholder="{{ __('Enter Password') }}">
											
										</div>
									</div> -->
									
		
									<!-- <div class="row">
										<div class="col-lg-12">
											<div class="checkbox-wrapper">
												<input type="checkbox" name="seo_check" value="1" class="checkclick"
													id="allowProductSEO" value="1">
												<label for="allowProductSEO">{{ __('Allow Product SEO') }}</label>
											</div>
										</div>
									</div>
		
		
		
									<div class="showbox">
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ __('Meta Tags') }} *</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<ul id="metatags" class="myTags">
												</ul>
											</div>
										</div>
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">
														{{ __('Meta Description') }} *
													</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="text-editor">
													<textarea name="meta_description" class="input-field"
														placeholder="{{ __('Meta Description') }}"></textarea>
												</div>
											</div>
										</div>
									</div> -->
		

		
		
									<div class="row">
										<div class="col-lg-12 text-center">
											<button class="addProductSubmit-btn"
												type="submit">{{ __('Add') }}</button>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	</form>
	
</div>
<div class="modal fade" id="userotp" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
						
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="submit-loader">
					<img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
			</div>
			<div class="modal-header">
				<h5 class="modal-title">Please Enter Your OTP</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="login-form">
                    <form class="student-log-reg-form modal-form mloginform" action="{{ route('sales-user-otp-submit') }}" method="POST" id="userCreateOtpForm">
                        {{ csrf_field() }}
                        @include('includes.sales.form-both')
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="resend-otp text-right">
                                    <a href="javascript:void('0');" class="resend-otp-text" id="resend-user-otp" data-href="{{ route('sales-user-resendotp') }}">RESEND OTP</a>
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
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
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
    function otpmodal() {
        // alert(1);
    $('.modal').modal('hide');
    $('#userotp').modal('show');
}
</script>
<script>
    $(document).ready(function(){
    $("#userotp").modal({
    show:false,
    backdrop:'static'
    });
    });
</script>
<script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>



<script type="text/javascript">
	$('.cropme').simpleCropper();
</script>



<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection