@extends('layouts.front')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/checkout.css')}}">
<style type="text/css">

.root.root--in-iframe {
    background: #4682b447 !important;
}
.tea-names {
    display: flex;
}
.smells {
	width: 135px;
    height: 135px;
    background: #4c9a2a;
    margin-right: 20px;
    text-align: center;
    border-radius: 50%;
    font-size: 20px;
    line-height: 20px;
    padding-top: 2.8rem;
    color: #fff;
    font-weight: 600;
}
.product-content {
    margin-top: 1rem;
}
</style>

@endsection

@section('content')
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-title-div">
                    <div class="bread-left-side">
                        <h2>Checkout</h2>
                    </div>
                    <div class="breadcrumb-ul right-side">
                        <ul>
                        <li><a href="{{ route('front.index') }}">HOME</a>/</li>
                        <li>
                          <a href="{{ route('front.customteacheckout') }}">
                            {{ __('Checkout') }}
                          </a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area Start -->

<!-- Breadcrumb Area End -->

	<!-- Check Out Area Start -->
	<section class="checkout">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="checkout-area mb-0 pb-0">
						<div class="checkout-process">
							<ul class="nav"  role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-step1-tab" data-toggle="pill" href="#pills-step1" role="tab" aria-controls="pills-step1" aria-selected="true">
									<span>1</span> {{ __('Address') }}
									<i class="far fa-address-card"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link disabled" id="pills-step2-tab" data-toggle="pill" href="#pills-step2" role="tab" aria-controls="pills-step2" aria-selected="false" >
										<span>2</span> {{ __('Orders') }}
										<i class="fas fa-dolly"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link disabled" id="pills-step3-tab" data-toggle="pill" href="#pills-step3" role="tab" aria-controls="pills-step3" aria-selected="false">
											<span>3</span> {{ __('Payment') }}
											<i class="far fa-credit-card"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>


				<div class="col-lg-8">


		<form id="" action="" method="POST" class="checkoutform">

			@include('includes.form-success')
			@include('includes.form-error')

			{{ csrf_field() }}

					<div class="checkout-area">
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-step1" role="tabpanel" aria-labelledby="pills-step1-tab">
								<div class="content-box">

									<div class="content">
										<div class="personal-info">
											<h5 class="title">
												{{__('Personal Information') }} :
											</h5>
											<div class="row">
												<div class="col-lg-6">
													<input type="text" id="personal-name" class="form-control" name="personal_name" placeholder="{{ __('Enter Your Name') }}" value="{{ Auth::check() ? Auth::user()->name : '' }}" {!! Auth::check() ? 'readonly' : '' !!}>
												</div>
												<div class="col-lg-6">
													<input type="email" id="personal-email" class="form-control" name="personal_email" placeholder="{{ __('Enter Your Email') }}" value="{{ Auth::check() ? Auth::user()->email : '' }}"  {!! Auth::check() ? 'readonly' : '' !!}>
												</div>
											</div>
											
										</div>
										<div class="billing-address">
											<h5 class="title">
												{{__('Billing Details') }}
											</h5>
											<div class="row">
												<div class="col-lg-6">
													<select class="form-control" id="shipop" name="shipping" required="">
														<option value="shipto">{{ __('Ship To Address') }}</option>
														<!-- <option value="pickup">{{ __('Pick Up') }}</option> -->
													</select>
												</div>

												

												<div class="col-lg-6">
													<input class="form-control" type="text" name="name"
														placeholder="{{ __('Full Name') }}" required=""
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->name : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="phone"
														placeholder="{{__('Phone Number') }}" required=""
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->phone : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="email"
														placeholder="{{ __('Email') }}" required=""
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->email : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="address"
														placeholder="{{ __('Address') }}" required=""
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->address : '' }}">
												</div>
												<div class="col-lg-6">
													<select class="form-control" id="select_country" name="customer_country" required="">
														@include('includes.countries')
													</select>
												</div>

												<div class="col-lg-6 {{Auth::check() ? '' : 'd-none'}} select_state">
													<select class="form-control " id="show_state" name="customer_state" required="">

													</select>
												</div>

												<div class="col-lg-6">
													<input class="form-control" type="text" name="city"
														placeholder="{{ __('City') }}" required=""
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->city : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="zip"
														placeholder="{{ __('Postal Code') }}" minlength="6" maxlength="6" required=""
														value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->zip : '' }}" id="zipcode">
												</div>
											</div>
										</div>
										
										<div class="order-note mt-3">
											<div class="row">
												<div class="col-lg-12">
												<input type="text" id="Order_Note" class="form-control" name="order_notes" placeholder="{{ __('Order Note') }} ({{ __('Optional') }})">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12  mt-3">
												<div class="bottom-area paystack-area-btn">
													<button type="submit"  class="mybtn1">{{ __('Continue') }}</button>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-step2" role="tabpanel" aria-labelledby="pills-step2-tab">
								<div class="content-box">
									<div class="content">

										<div class="order-area">
										@php
										$smellProduct=App\Models\CustomTea::where('type','=','1')->where('id',$usercustomtea->smell)->first();
										$colorProduct=App\Models\CustomTea::where('type','=','2')->where('id',$usercustomtea->color)->first();
										$colorper=$usercustomtea->weight*($usercustomtea->color_per/100);
										$smellper=$usercustomtea->weight*($usercustomtea->smell_per/100);
										$colorprice=$colorper*$colorProduct->price;
										$smellprice=$smellper*$smellProduct->price;
										@endphp
											<div class="order-item">
												<div class="product-img"> <div class="tea-names"> <div class="smells">Smell Component</div>  </div> </div> 
												<div class="product-content"> 
													<p class="name"><a href="javascript:void('0');">{{$smellProduct->name}}</a></p>
													<div class="unit-price"> 
														<h5 class="label">Price : </h5> <p>₹{{$smellprice}}</p>  
													</div>
													<div class="quantity"> 
														<h5 class="label">Weight(gm) : </h5> <span class="qttotal">{{$smellper}} </span> 
													</div>
													<div class="total-price"> 
														<h5 class="label">Percentage : </h5> <p>{{$usercustomtea->smell_per}}% </p> 
													</div> 
												</div>
											</div>	
											<div class="order-item">
												<div class="product-img"> <div class="tea-names"> <div class="smells">Colour Component</div>  </div> </div> 
												<div class="product-content"> 
													<p class="name"><a href="javascript:void('0');">{{$colorProduct->name}}</a></p>
													<div class="unit-price"> 
														<h5 class="label">Price : </h5> <p>₹{{$colorprice}}</p>  
													</div>
													<div class="quantity"> 
														<h5 class="label">Weight(gm) : </h5> <span class="qttotal">{{$colorper}}  </span> 
													</div>
													<div class="total-price"> 
														<h5 class="label">Percentage : </h5> <p>{{$usercustomtea->color_per}}% </p> 
													</div> 
												</div>
											</div>	
										</div>

										<div class="row">
											<div class="col-lg-12 mt-3">
												<div class="bottom-area">
													<a href="javascript:;" id="step1-btn"  class="mybtn1 mr-3">{{ __('Back') }}</a>
													<a href="javascript:;" id="step3-btn"  class="mybtn2">{{ __('Continue') }}</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-step3" role="tabpanel" aria-labelledby="pills-step3-tab">
								<div class="content-box">
									<div class="content">

											<div class="billing-info-area">
															<h4 class="title">
																	{{ __('Shipping Info') }}
															</h4>
													<ul class="info-list">
														<li>
															<p id="shipping_user"></p>
														</li>
														<li>
															<p id="shipping_location"></p>
														</li>
														<li>
															<p id="shipping_phone"></p>
														</li>
														<li>
															<p id="shipping_email"></p>
														</li>
													</ul>
											</div>
											<div class="payment-information">
													<h4 class="title">
														{{ __('Payment Info') }}
													</h4>
													<div class="row">
														<div class="col-lg-12">
															<div class="nav flex-column" role="tablist"
																aria-orientation="vertical">
				
																@foreach($gateways as $gt)
				
																@if($gt->type == 'manual')
				
																	
				
																	<a class="nav-link payment" data-val="" data-show="{{$gt->showForm()}}"
																		data-form="{{ $gt->showCheckoutLink('customtea') }}"
																		data-href="{{ route('front.load.payment',['slug1' => $gt->showKeyword(),'slug2' => $gt->id]) }}"
																		id="v-pills-tab{{ $gt->id }}-tab" data-toggle="pill"
																		href="#v-pills-tab{{ $gt->id }}" role="tab"
																		aria-controls="v-pills-tab{{ $gt->id }}"
																		aria-selected="false">
																		<div class="icon">
																			<span class="radio"></span>
																		</div>
																		<p>
																			{{ $gt->title }}
				
																			@if($gt->subtitle != null)
				
																			<small>
																				{{ $gt->subtitle }}
																			</small>
				
																			@endif
				
																		</p>
																	</a>
				
				
																@else
				
																<a class="nav-link payment" data-val="{{ $gt->keyword }}" data-show="{{$gt->showForm()}}"
																	data-form="{{ $gt->showCheckoutLink('customtea') }}"
																	data-href="{{ route('front.load.payment',['slug1' => $gt->showKeyword(),'slug2' => $gt->id]) }}"
																	id="v-pills-tab{{ $gt->id }}-tab" data-toggle="pill"
																	href="#v-pills-tab{{ $gt->id }}" role="tab"
																	aria-controls="v-pills-tab{{ $gt->id }}"
																	aria-selected="false">
																	<div class="icon">
																		<span class="radio"></span>
																	</div>
																	<p>
																		{{ $gt->name }}
				
																		@if($gt->information != null)
				
																		<small>
																			{{ $gt->getAutoDataText() }}
																		</small>
				
																		@endif
				
																	</p>
																</a>
				
																@endif
				
																@endforeach
				
				
															</div>
														</div>
														<div class="col-lg-12">
															<div class="pay-area d-none">
																<div class="tab-content" id="v-pills-tabContent">
				
																	@foreach($gateways as $gt)
				
																		@if($gt->type == 'manual')
				
				
																				<div class="tab-pane fade" id="v-pills-tab{{ $gt->id }}"
																					role="tabpanel"
																					aria-labelledby="v-pills-tab{{ $gt->id }}-tab">
				
																				</div>
				
																		@else
				
																		<div class="tab-pane fade" id="v-pills-tab{{ $gt->id }}"
																			role="tabpanel"
																			aria-labelledby="v-pills-tab{{ $gt->id }}-tab">
				
																		</div>
				
																		@endif
				
																	@endforeach
																</div>
															</div>
														</div>
													</div>
											</div>

										<div class="row">
												<div class="col-lg-12 mt-3">
													<div class="bottom-area">

															<a href="javascript:;" id="step2-btn" class="mybtn1 mr-3">{{ __('Back')}}</a>
															<button type="submit" id="final-btn" class="mybtn1">{{ __('Continue') }}</button>
													</div>

												</div>
											</div>
									</div>
								</div>
							</div>
						</div>
					</div>


                            <input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
                            <input type="hidden" id="packing-cost" name="packing_cost" value="0">
                            <input type="hidden" id="input_tax" name="tax" value="">
                            <input type="hidden" id="input_tax_type" name="tax_type" value="">


							@if(Session::has('coupon_total'))
                            	<input type="hidden" name="total" id="grandtotal" value="{{ $totalPrice }}">
								<input type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
							@elseif(Session::has('coupon_total1'))
								<input type="hidden" name="total" id="grandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
								<input type="hidden" id="tgrandtotal" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') ) }}">
							@else
                            	<input type="hidden" name="total" id="grandtotal" value="{{round($totalPrice * $curr->value,2)}}">
								<input type="hidden" id="tgrandtotal" value="{{round($totalPrice * $curr->value,2)}}">
							@endif
							<input type="hidden" id="original_tax" value="0">
							<input type="hidden" id="wallet-price" name="wallet_price" value="0">
							<input type="hidden" id="ttotal" value="{{ $totalPrice }}">
                            <input type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
                            <input type="hidden" name="coupon_discount" id="coupon_discount" value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
                            <input type="hidden" name="coupon_id" id="coupon_id" value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">



</form>


				</div>

				
				<div class="col-lg-4">
					<div class="right-area">
						<div class="order-box">
						<h4 class="title">{{ __('PRICE DETAILS') }}</h4>
						<ul class="order-list">
							<li>
							<p>
								{{ __('Price') }}
							</p>
							<P>
								<b
								class="cart-total">{{ isset($usercustomtea->price) ? $usercustomtea->price : '0.00' }}</b>
							</P>
							</li>
							

							<!-- <li class="tax_show  d-none">
								<p>
									{{ __('Tax')}}
								</p>
								<P>
									<b> <span class="original_tax">0</span> % </b>
								</P>
								</li> -->




							@if(Session::has('coupon'))


							<li class="discount-bar">
							<p>
								{{ __('Discount') }} <span class="dpercent">{{ Session::get('coupon_percentage') == 0 ? '' : '('.Session::get('coupon_percentage').')' }}</span>
							</p>
							<P>
								@if($gs->currency_format == 0)
									<b id="discount">{{ $curr->sign }}{{ Session::get('coupon') }}</b>
								@else
									<b id="discount">{{ Session::get('coupon') }}{{ $curr->sign }}</b>
								@endif
							</P>
							</li>


							@else


							<li class="discount-bar d-none">
							<p>
								{{ __('Discount') }} <span class="dpercent"></span>
							</p>
							<P>
								<b id="discount">{{ $curr->sign }}{{ Session::get('coupon') }}</b>
							</P>
							</li>


							@endif

						</ul>

		            <div class="total-price">
		              <p>
		                {{ __('Total') }}
		              </p>
		              <p>

						
								<span id="total-costs">{{ $curr->sign }}{{ $totalPrice }}</span>


		              </p>
		            </div>
					<div style="display:flex;" class="total-price">
						<p>
							{{ __('Shipping') }}
						</p>
						<?php
						// print_r($shipping_data['1']->price);
						?>
						<input type="hidden" class="shipping" id="free-shepping" name="shipping" value="{{ round($shipping_data['1']->price * $curr->value,2) }}" >
						<p syle="text-align:right;">
							<span class="cart-total" id="shipping-charge">
								@if($shipping_data['1']->price != 0)
								+ {{ $curr->sign }}{{ round($shipping_data['1']->price * $curr->value,2) }}
								@endif
							</span>
						</p>
					</div>


						<!-- <div class="cupon-box">

							<div id="coupon-link">
							<img src="{{ asset('assets/front/images/tag.png') }}">
							{{ __('Have a promotion code?') }}
							</div>

						    <form id="check-coupon-form" class="coupon">
						        <input type="text" placeholder="{{ __('Coupon Code') }}" id="code" required="" autocomplete="off">
						        <button type="submit">{{ __('Apply') }}</button>
						    </form>


						</div> -->

					

						
						{{-- Packeging Area End Start--}}

						{{-- Final Price Area Start--}}
						<div class="final-price">
							<span>{{ __('Final Price') }} :</span>
						@if(Session::has('coupon_total'))
							@if($gs->currency_format == 0)
								<span id="final-cost">{{ $curr->sign }}{{ $totalPrice }}</span>
							@else
								<span id="final-cost">{{ $totalPrice }}{{ $curr->sign }}</span>
							@endif

						@elseif(Session::has('coupon_total1'))
							<span id="final-cost"> {{ Session::get('coupon_total1') }}</span>
							@else
							<span id="final-cost">{{ App\Models\Product::convertPrice($totalPrice) }}</span>
						@endif



						</div>
						{{-- Final Price Area End --}}

					

					{{-- Wallet Area Start--}}

					<div class="wallet-price d-none">
						<span>{{ __('Wallet Amount:') }}</span>
						@if($gs->currency_format == 0)
							<span id="wallet-cost"></span>
						@else
							<span id="wallet-cost"></span>
						@endif
					</div>
			

			@if(Auth::check())

				@if(Auth::user()->balance > 0)
				
				<div class="wallet-balace-money mt-3"><p><i class="icofont-wallet"></i> Wallet Balance: <span>{{Auth::user()->balance}}</p></div>
				<div class="mt-3">
					<input class="styled-checkbox" id="wallet" type="checkbox" value="value1">
					<label for="wallet">{{ __('Pay From Your Wallet') }}</label>
				</div>
				<div class="wallet-box mt-3 d-none">

					<form id="wallet-form">

						@if(Session::has('coupon_total'))

						<input type="number" placeholder="{{  __('Enter Amount')}}" step="0.01" id="wallet-amount" min="1" required="" value="{{ $totalPrice <= ( Auth::user()->balance * $curr->value ) ? $totalPrice :  round(Auth::user()->balance * $curr->value ,2) }}">

						@elseif(Session::has('coupon_total1'))

						<input type="number" placeholder="{{ __('Enter Amount') }}" step="0.01" id="wallet-amount" min="1" required="" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1')) <= ( Auth::user()->balance * $curr->value ) ? preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1')) :  round(Auth::user()->balance * $curr->value ,2) }}">

						@else

						<input type="number" class="form-control" placeholder="{{ __('Enter Amount') }}" step="0.01" id="wallet-amount" min="1" required="" value="">

						@endif

						<button class="mybtn1 mt-3" type="submit">{{ __('SUBMIT') }}</button>
					</form>

				</div>
				@endif
			@endif


		{{-- Wallet Area End --}}

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
		<!-- Check Out Area End-->

@if(isset($checked))

<!-- LOGIN MODAL -->
<div class="modal fade" id="comment-log-reg1" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" aria-label="Close">
          <a href="{{ url()->previous() }}"><span aria-hidden="true">&times;</span></a>
        </button>
      </div>
      <div class="modal-body">
				<nav class="comment-log-reg-tabmenu">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link login active" id="nav-log-tab" data-toggle="tab" href="#nav-log" role="tab" aria-controls="nav-log" aria-selected="true">
							{{ __('Login') }}
						</a>
						<a class="nav-item nav-link" id="nav-reg-tab" data-toggle="tab" href="#nav-reg" role="tab" aria-controls="nav-reg" aria-selected="false">
							{{ __('Register') }}
						</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-log" role="tabpanel" aria-labelledby="nav-log-tab">
				        <div class="login-area">
				          <div class="header-area">
				            <h4 class="title">{{ __('LOGIN NOW') }}</h4>
				          </div>
				          <div class="login-form signin-form">
				                @include('includes.admin.form-login')
				            <form id="loginform" action="{{ route('user.login.submit') }}" method="POST">
				              {{ csrf_field() }}
				              <div class="form-input">
				                <input type="email" name="email" placeholder="{{ __('Type Email Address') }}" required="">
				                <i class="icofont-user-alt-5"></i>
				              </div>
				              <div class="form-input">
				                <input type="password" class="Password" name="password" placeholder="{{ __('Type Password') }}" required="">
				                <i class="icofont-ui-password"></i>
				              </div>
				              <div class="form-forgot-pass">
				                <div class="left">
				              <input type="hidden" name="modal" value="1">
				                  <input type="checkbox" name="remember"  id="mrp" {{ old('remember') ? 'checked' : '' }}>
				                  <label for="mrp">{{ __('Remember Password') }}</label>
				                </div>
				                <div class="right">
				                  <a href="{{ route('user-forgot') }}">
				                    {{ __('Forgot Password?') }}
				                  </a>
				                </div>
				              </div>
				              <input id="authdata" type="hidden"  value="{{ __('Authenticating...') }}">
				              <button type="submit" class="submit-btn">{{ __('Login') }}</button>
					              @if(App\Models\Socialsetting::find(1)->f_check == 1 || App\Models\Socialsetting::find(1)->g_check == 1)
					              <div class="social-area">
					                  <h3 class="title">{{ __('Or')}}</h3>
					                  <p class="text">{{__('Sign In with social media')}}</p>
					                  <ul class="social-links">
					                    @if(App\Models\Socialsetting::find(1)->f_check == 1)
					                    <li>
					                      <a href="{{ route('social-provider','facebook') }}">
					                        <i class="fab fa-facebook-f"></i>
					                      </a>
					                    </li>
					                    @endif
					                    @if(App\Models\Socialsetting::find(1)->g_check == 1)
					                    <li>
					                      <a href="{{ route('social-provider','google') }}">
					                        <i class="fab fa-google-plus-g"></i>
					                      </a>
					                    </li>
					                    @endif
					                  </ul>
					              </div>
					              @endif
				            </form>
				          </div>
				        </div>
					</div>
					
					<div class="tab-pane fade" id="nav-reg" role="tabpanel" aria-labelledby="nav-reg-tab">
                <div class="login-area signup-area">
                    <div class="header-area">
                        <h4 class="title">{{ __('Signup Now') }}</h4>
                    </div>
                    <div class="login-form signup-form">
                       @include('includes.admin.form-login')
                        <form id="registerform" action="{{route('user-register-submit')}}" method="POST">
                          {{ csrf_field() }}

                            <div class="form-input">
                                <input type="text" class="User Name" name="name" placeholder="{{ __('Full Name') }}" required="">
                                <i class="icofont-user-alt-5"></i>
                            </div>

                            <div class="form-input">
                                <input type="email" class="User Name" name="email" placeholder="{{ __('Email Address') }}" required="">
                                <i class="icofont-email"></i>
                            </div>

                            <div class="form-input">
                                <input type="text" class="User Name" name="phone" placeholder="{{__('Phone Number') }}" required="">
                                <i class="icofont-phone"></i>
                            </div>

                            <div class="form-input">
                                <input type="text" class="User Name" name="address" placeholder="{{ __('Address') }}" required="">
                                <i class="icofont-location-pin"></i>
                            </div>

                            <div class="form-input">
                                <input type="password" class="Password" name="password" placeholder="{{ __('Password') }}" required="">
                                <i class="icofont-ui-password"></i>
                            </div>

                            <div class="form-input">
                                <input type="password" class="Password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required="">
                                <i class="icofont-ui-password"></i>
                            </div>

							@if($gs->is_capcha == 1)

								<ul class="captcha-area">
									<li>
										<p><img class="codeimg1" src="{{asset("assets/images/capcha_code.png")}}" alt=""> <i class="fas fa-sync-alt pointer refresh_code "></i></p>
									</li>
								</ul>

								<div class="form-input">
									<input type="text" class="Password" name="codes" placeholder="{{ __('Enter Code') }}" required="">
									<i class="icofont-refresh"></i>
								</div>
							@endif

                            <input id="processdata" type="hidden"  value="{{ __('Processing...') }}">
                            <button type="submit" class="submit-btn">{{ __('Register') }}</button>

                        </form>
                    </div>
                </div>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>
<!-- LOGIN MODAL ENDS -->

@endif

@endsection

@section('scripts')

<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>



<script type="text/javascript">

	$('a.payment:first').addClass('active');
	$('.checkoutform').prop('action',$('a.payment:first').data('form'));
	$($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));


		var show = $('a.payment:first').data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
	$($('a.payment:first').attr('href')).addClass('active').addClass('show');
</script>


<script type="text/javascript">

var coup = 0;
var pos = {{ $gs->currency_format }};

@if(isset($checked))

	$('#comment-log-reg1').modal('show');

@endif

var mship = $('.shipping').length > 0 ? $('.shipping').first().val() : 0;
var mpack = $('.packing').length > 0 ? $('.packing').first().val() : 0;
mship = parseFloat(mship);
mpack = parseFloat(mpack);

$('#shipping-cost').val(mship);
$('#packing-cost').val(mpack);
var ftotal = parseFloat($('#grandtotal').val()) + mship + mpack;
ftotal = parseFloat(ftotal).toFixed(parseFloat);

		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ftotal)
		}
		else{
			$('#final-cost').html(ftotal+'{{ $curr->sign }}')
		}

$('#grandtotal').val(ftotal);




let original_tax = 0;

	$(document).on('change','#select_country',function(){
		
		$(this).attr('data-href');

		let state_id = 0;

		let country_id = $('#select_country option:selected').attr('data');
		let is_state = $('option:selected', this).attr('rel');
		let is_auth = $('option:selected', this).attr('rel1');
		let is_user = $('option:selected', this).attr('rel5');
		let state_url = $('option:selected', this).attr('data-href');


		if(is_auth == 1 || is_state == 1) {
			
			if(is_state == 1){
				$('.select_state').removeClass('d-none');
				$.get(state_url,function(response){
					$('#show_state').html(response.data);
					if(is_user==1){
						tax_submit(country_id,response.state);
					}else{
						tax_submit(country_id,state_id);
					}
					
				});
				
			}else{
				
				tax_submit(country_id,state_id);
				hide_state();
			}

		}else{
			
			tax_submit(country_id,state_id);
			hide_state();
		}

	});


	$(document).on('change','#show_state',function(){
		let state_id = $(this).val();
		let country_id = $('#select_country option:selected').attr('data');
		tax_submit(country_id,state_id);
	});


	function hide_state(){
		$('.select_state').addClass('d-none');
	}


	$(document).on('ready',function(){

		let country_id = $('#select_country option:selected').attr('data');
		let state_id = $('#select_country option:selected').attr('rel2');
		let is_state = $('#select_country option:selected', this).attr('rel');
		let is_auth = $('#select_country option:selected', this).attr('rel1');
		let state_url = $('#select_country option:selected', this).attr('data-href');

		if(is_auth == 1 && is_state ==1) {
			if(is_state == 1){
				$('.select_state').removeClass('d-none');
				$.get(state_url,function(response){
					$('#show_state').html(response.data);
					tax_submit(country_id,response.state);
				});

			}else{
				tax_submit(country_id,state_id);
				hide_state();
			}
		}else{
			tax_submit(country_id,state_id);
			hide_state();
		}
	});


	

	function tax_submit(country_id,state_id){
		
		$('.gocover').show();
		var total = $("#ttotal").val();
		var ship = 0;
		$.ajax({
                    type: "GET",
                    url:mainurl+"/country/tax/check",
                    data:{state_id:state_id,country_id : country_id,total:total, shipping_cost:ship},
                    success:function(data){
							console.log(data);
							$('#grandtotal').val(data[0]);
							$('#tgrandtotal').val(data[0]);
							$('#original_tax').val(data[1]);
							$('.tax_show').removeClass('d-none');
							$('#input_tax').val(data[11]);
							$('#input_tax_type').val(data[12]);
							$('.original_tax').html(parseFloat(data[1]).toFixed(2));
                            var ttotal = parseFloat($('#grandtotal').val());
                            var tttotal = parseFloat($('#grandtotal').val()) + (parseFloat(mship) + parseFloat(mpack));
                            ttotal = parseFloat(ttotal).toFixed(2);
                            tttotal = parseFloat(tttotal).toFixed(2);

                            if(pos == 0){
							$('#final-cost').html('{{ $curr->sign }}'+tttotal);
							$('#total-cost').html('{{ $curr->sign }}'+ttotal);
								}
								else{
								$('#final-cost').html(tttotal+'{{ $curr->sign }}');
								$('#total-cost').html(ttotal+'{{ $curr->sign }}');
								}
							$('.gocover').hide();
                      }
              });
	}









// Wallet Area Starts

$('#wallet').on('change',function(){
	if(this.checked){
		$('.wallet-box').removeClass('d-none')
	}else{
		$('.wallet-box').addClass('d-none')
	}
});


$("#wallet-form").on('submit', function (e) {
	e.preventDefault();
		var prev_wallet_price = parseFloat($("#wallet-price").val());
        var val = parseFloat($("#wallet-amount").val());
        var total = $("#grandtotal").val();
		var shipping_cost = $("#shipping-cost").val();

            $.ajax({
                    type: "GET",
                    url:mainurl+"/wallet/check",
                    data:{code:val, total:total, prev_price:prev_wallet_price, shipping_cost:shipping_cost},
                    success:function(data){
                        if(data == 0){
                        	toastr.error('Insufficient Amount!');
                        }
						else if(data == 1){
							toastr.error('Balance Exceeds From Wallet!');
						}
                        else{
							$("#wallet-amount").val('');
							$('#wallet').click();
							$("#grandtotal").val(data[0].toFixed(2));
							$("#tgrandtotal").val(data[2].toFixed(2));
							var wallet_price = parseFloat($("#wallet-price").val());
							if(wallet_price != 0){
								var wprice = data[1] + wallet_price;
								$("#wallet-price").val(wprice);
							}else{
								$("#wallet-price").val(data[1]);
							}
							$('.wallet-price').removeClass('d-none');
							if(pos == 0){
								$('#wallet-cost').html('{{ $curr->sign }}'+(data[1]+wallet_price));
								$('#final-cost').html('{{ $curr->sign }}'+data[0].toFixed(2));
							}
							else{
								$('#wallet-cost').html((data[1]+wallet_price)+'{{ $curr->sign }}');
								$('#final-cost').html(data[0].toFixed(2)+'{{ $curr->sign }}');
							}
							$('.shipping').prop('disabled',true);
							$('.packing').prop('disabled',true);
							$('#check-coupon-form button').prop('disabled',true);
							if(data[0] == 0){
								$('.checkoutform').prop('action','{{ route('wallet.submit') }}');
								$('.payment-information').addClass('d-none');
							}
                        	toastr.success('Successfully Paid From Your Wallet.');
                        }
                      }
              });

    });

// Wallet Area Ends









$('#shipop').on('change',function(){

	var val = $(this).val();
	if(val == 'pickup'){
		$('#shipshow').removeClass('d-none');
		$("#ship-diff-address").parent().addClass('d-none');
        $('.ship-diff-addres-area').addClass('d-none');
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);
	}
	else{
		$('#shipshow').addClass('d-none');
		$("#ship-diff-address").parent().removeClass('d-none');
        $('.ship-diff-addres-area').removeClass('d-none');
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true);
	}

});
$('#zipcode').on('change',function(){
// $(document).on("change", "#zipcode" , function(){
        var zipcode = $(this).val();
        // alert(zipcode);
            $.ajax({
                    type: "GET",
                    url:mainurl+"/localpincodecheck",
                    data:{zipcode:zipcode},
                    success:function(data){
                      mship = data.shipping_charge;
                      // alert(mship);
                      $('#shipping-charge').html(data.shipping_charge_html);
                        $('#free-shepping').val(data.shipping_charge);
                        $('#shipping-cost').val(mship);
                        var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
                        ttotal = parseFloat(ttotal).toFixed(2);

                            if(pos == 0){
                              $('#final-cost').html('{{ $curr->sign }}'+ttotal);
                            }
                            else{
                              $('#final-cost').html(ttotal+'{{ $curr->sign }}');
                            }

                        $('#grandtotal').val(ttotal);
                      if(data.status=='1'){
                        // alert(1);
                        
                      }else{
                        // alert(0);
                      }
                      // toastr.success(langg.color_change);
                    }
              });
       });

$('.shipping').on('click',function(){
	mship = $(this).val();

$('#shipping-cost').val(mship);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal).toFixed(2);

		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ttotal);
		}
		else{
			$('#final-cost').html(ttotal+'{{ $curr->sign }}');
		}

$('#grandtotal').val(ttotal);

})

$('.packing').on('click',function(){
	mpack = $(this).val();
$('#packing-cost').val(mpack);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal).toFixed(2);;


if(pos == 0){
	$('#final-cost').html('{{ $curr->sign }}'+ttotal);
}
else{
	$('#final-cost').html(ttotal+'{{ $curr->sign }}');
}


$('#grandtotal').val(ttotal);

})

    $("#check-coupon-form").on('submit', function () {
        var val = $("#code").val();
        var total = $("#ttotal").val();
        var ship = $('#shipping-cost').val();
            $.ajax({
                    type: "GET",
                    url:mainurl+"/customtea/coupon/check",
                    data:{code:val, total:total, shipping_cost:ship},
                    success:function(data){
                        if(data == 0)
                        {
                        	toastr.error(langg.no_coupon);
                            $("#code").val("");
                        }
                        else if(data == 2)
                        {
                        	toastr.error(langg.already_coupon);
                            $("#code").val("");
                        }
                        else
                        {
                            $("#check-coupon-form").toggle();
                            $(".discount-bar").removeClass('d-none');

							if(pos == 0){
								$('#total-cost').html('{{ $curr->sign }}'+data[0]);
								$('#discount').html('{{ $curr->sign }}'+data[2]);
							}
							else{
								$('#total-cost').html(data[0]+'{{ $curr->sign }}');
								$('#discount').html(data[2]+'{{ $curr->sign }}');
							}
								$('#grandtotal').val(data[0]);
								$('#tgrandtotal').val(data[0]);
								$('#coupon_code').val(data[1]);
								$('#coupon_discount').val(data[2]);
								if(data[4] != 0){
								$('.dpercent').html('('+data[4]+')');
								}
								else{
								$('.dpercent').html('');
								}


var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

		if(pos == 0){
			$('#final-cost').html('{{ $curr->sign }}'+ttotal)
		}
		else{
			$('#final-cost').html(ttotal+'{{ $curr->sign }}')
		}
				toastr.success(langg.coupon_found);
				$("#code").val("");
                }
        	 }
        });
              return false;
    });

// Password Checking

        $("#open-pass").on( "change", function() {
            if(this.checked){
             $('.set-account-pass').removeClass('d-none');
             $('.set-account-pass input').prop('required',true);
             $('#personal-email').prop('required',true);
             $('#personal-name').prop('required',true);
            }
            else{
             $('.set-account-pass').addClass('d-none');
             $('.set-account-pass input').prop('required',false);
             $('#personal-email').prop('required',false);
             $('#personal-name').prop('required',false);

            }
        });

// Password Checking Ends


// Shipping Address Checking

		$("#ship-diff-address").on( "change", function() {
            if(this.checked){
             $('.ship-diff-addres-area').removeClass('d-none');
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true);
            }
            else{
             $('.ship-diff-addres-area').addClass('d-none');
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);
            }

        });


// Shipping Address Checking Ends


</script>


<script type="text/javascript">


var ck = 0;

	$('.checkoutform').on('submit',function(e){
		if(ck == 0) {
			e.preventDefault();
		$('#pills-step2-tab').removeClass('disabled');
		$('#pills-step2-tab').click();

	}else {
		$('#preloader').show();
	}
	$('#pills-step1-tab').addClass('active');
	});

	$('#step1-btn').on('click',function(){
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step2-tab').addClass('disabled');
		$('#pills-step3-tab').addClass('disabled');

		$('#pills-step1-tab').click();

	});

// Step 2 btn DONE

	$('#step2-btn').on('click',function(){
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').addClass('disabled');
		$('#pills-step2-tab').click();
		$('#pills-step1-tab').addClass('active');

	});
	
	$('#step3-btn').on('click',function(){
	 	if($('a.payment:first').data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
		
		$('#pills-step3-tab').removeClass('disabled');
		$('#pills-step3-tab').click();

		var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();
		var shipping_location  = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
		var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

		$('#shipping_user').html('<i class="fas fa-user"></i>'+shipping_user);
		$('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>'+shipping_location);
		$('#shipping_phone').html('<i class="fas fa-phone"></i>'+shipping_phone);
		$('#shipping_email').html('<i class="fas fa-envelope"></i>'+shipping_email);

		$('#pills-step1-tab').addClass('active');
		$('#pills-step2-tab').addClass('active');
	});

	$('#final-btn').on('click',function(){
		ck = 1;
	})



	$('.payment').on('click',function(){
		if($(this).data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
	
		else if($(this).data('val') == 'mercadopago'){
			$('.checkoutform').prop('id','mercadopago');
			checkONE= 1;
		}
		else {
			$('.checkoutform').prop('id','');
		}
		$('.checkoutform').prop('action',$(this).data('form'));
		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
		$($(this).attr('href')).load($(this).data('href'));
	})





        $(document).on('submit','#step1-form',function(){
			
        	$('#preloader').hide();
            var val = $('#sub').val();
            var total = $('#grandtotal').val();
			total = Math.round(total);
                if(val == 0)
                {
                var handler = PaystackPop.setup({
                  key: '{{$paystackData['key']}}',
                  email: $('input[name=email]').val(),
                  amount: total * 100,
                  currency: "{{$curr->name}}",
                  ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                  callback: function(response){
                    $('#ref_id').val(response.reference);
                    $('#sub').val('1');
                    $('#final-btn').click();
                  },
                  onClose: function(){
                  	window.location.reload();

                  }
                });
                handler.openIframe();
                    return false;
                }
                else {
                	$('#preloader').show();
                    return true;
                }
        });



</script>

@endsection
