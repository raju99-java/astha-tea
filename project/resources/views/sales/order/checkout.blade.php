@extends('layouts.sales')

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/checkout.css')}}">
<style type="text/css">

.root.root--in-iframe {
    background: #4682b447 !important;
}
.mybtn1 {
    line-height: 28px !important;
}
.info-list {
    list-style: none !important;
    padding-left: 0px !important;
}
</style>
<link rel="stylesheet" href="{{asset('assets/front/css/toastr.css')}}">
@endsection

@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Checkout') }} 
				</h4>
				<ul class="links">
					<li>
						<a href="{{ route('sales.dashboard') }}">{{ __('Dashboard') }} </a>
					</li>
					<li>
						<a href="javascript:;">{{ __('Checkout') }} </a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
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
									
									<div class="content" >
										<div class="personal-info">
											<h5 class="title">
												{{__('Order Type') }} :
											</h5>
											<div class="col-lg-14">
												<select class="form-control" id="order_type" name="order_type" required="">
													<option value="offline">{{ __('Offline') }}</option>
													<option value="online">{{ __('Online') }}</option>
													
												</select>
											</div>
											
										</div>
										<div id="main-info" class="d-none">
										
										<div class="personal-info">
											<h5 class="title">
												{{__('Personal Information') }} :
											</h5>
											<div class="row">
												<div class="col-lg-6">
													<input type="text" id="personal-name" class="form-control" name="personal_name" placeholder="{{ __('Enter Name') }}" value="{{ isset($user->name) ? $user->name : '' }}" >
												</div>
												<div class="col-lg-6">
													<input type="phone" id="personal-phone" class="form-control" name="personal_phone" placeholder="{{ __('Enter Phone') }}" value="{{ isset($user->phone) ? $user->phone : '' }}" >
												</div>
											</div>
											
										</div>
										
										<div class="billing-address">
											<h5 class="title">
												{{__('Billing Details') }}
											</h5>
											<div class="row">
												<div class="col-lg-6 {{ $digital == 1 ? 'd-none' : '' }}">
													<select class="form-control" id="shipop" name="shipping" required="">
														<option value="shipto">{{ __('Ship To Address') }}</option>
														<!-- <option value="pickup">{{ __('Pick Up') }}</option> -->
													</select>
												</div>

												<div class="col-lg-6 d-none" id="shipshow">
													<select class="form-control nice" name="pickup_location">
														@foreach($pickups as $pickup)
														<option value="{{$pickup->location}}">{{$pickup->location}}</option>
														@endforeach
													</select>
												</div>

												<div class="col-lg-6">
													<input class="form-control" type="text" name="name"
														placeholder="{{ __('Full Name') }}" required=""
														value="{{ isset($user->name) ? $user->name : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="phone"
														placeholder="{{__('Phone Number') }}" required=""
														value="{{ isset($user->phone) ? $user->phone : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="email"
														placeholder="{{ __('Email') }}" 
														value="{{ isset($user->email) ? $user->email : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="address" id="address"
														placeholder="{{ __('Address') }}" 
														value="{{ isset($user->address) ? $user->address : '' }}">
												</div>
												<!-- <div class="col-lg-6">
													<select class="form-control" id="select_country" name="customer_country" required="">
														@include('includes.countries')
													</select>
												</div>

												<div class="col-lg-6 {{Auth::check() ? '' : 'd-none'}} select_state">
													<select class="form-control " id="show_state" name="customer_state" required="">

													</select>
												</div> -->

												<div class="col-lg-6">
													<input class="form-control" type="text" name="city" id="city"
														placeholder="{{ __('City') }}" required=""
														value="{{ isset($user->city) ? $user->city : '' }}">
												</div>
												<div class="col-lg-6">
													<input class="form-control" type="text" name="zip"
														placeholder="{{ __('Postal Code') }}" minlength="6" maxlength="6" 
														value="{{ isset($user->zip) ? $user->zip : '' }}" id="zipcode">
												</div>
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
											@foreach($products as $product)
											<div class="order-item">
												<div class="product-img">
													<div class="d-flex">
														<img src=" {{ asset('assets/images/products/'.$product['item']['photo']) }}"
															height="80" width="80" class="p-1">

													</div>
												</div>
												<div class="product-content">
													<p class="name"><a
															href="{{ route('front.product', $product['item']['slug']) }}"
															target="_blank">{{ $product['item']['name'] }}</a></p>
													<div class="unit-price">
														<h5 class="label">{{ __('Price') }} : </h5>
														<p>{{ App\Models\Product::convertPrice($product['item_price']) }}</p>
													</div>
													@if(!empty($product['size']))
													<div class="unit-price">
														<h5 class="label">{{ __('Size') }} : </h5>
														<p>{{ str_replace('-',' ',$product['size']) }}</p>
													</div>
													@endif
													@if(!empty($product['color']))
													<div class="unit-price">
														<h5 class="label">{{ __('Color') }} : </h5>
														<span id="color-bar" style="border: 10px solid {{$product['color'] == "" ? "white" : '#'.$product['color']}};"></span>
													</div>
													@endif
													@if(!empty($product['keys']))

													@foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

														<div class="quantity">
															<h5 class="label">{{ ucwords(str_replace('_', ' ', $key))  }} : </h5>
															<span class="qttotal">{{ $value }} </span>
														</div>
													@endforeach

													@endif
													<div class="quantity">
														<h5 class="label">{{ __('Quantity') }} : </h5>
														<span class="qttotal">{{ $product['qty'] }} </span>
													</div>
													<div class="total-price">
														<h5 class="label">{{ __('Total Price') }} : </h5>
														<p>{{ App\Models\Product::convertPrice($product['price']) }}
														</p>
													</div>
												</div>
											</div>

											@endforeach

										</div>

										<div class="row">
											<div class="col-lg-12 mt-3">
												<div class="bottom-area">
													<a href="javascript:;" id="step1-btn"  class="mybtn1 mr-3">{{ __('Back') }}</a>
													<a href="javascript:;" id="step3-btn"  class="mybtn1">{{ __('Continue') }}</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-step3" role="tabpanel" aria-labelledby="pills-step3-tab">
								<div class="content-box">
									<div class="content">

											<div class="billing-info-area {{ $digital == 1 ? 'd-none' : '' }}">
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
				
																	@if($digital == 0)
				
																	<a class="nav-link payment" data-val="" data-show="{{$gt->showForm()}}"
																		data-form="{{ $gt->showCheckoutLink('other') }}"
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
				
																	@endif
				
				
																
				
																@endif
				
																@endforeach
				
				
															</div>
														</div>
														<div class="col-lg-12">
															<div class="pay-area d-none">
																<div class="tab-content" id="v-pills-tabContent">
				
																	@foreach($gateways as $gt)
				
																		@if($gt->type == 'manual')
				
																			@if($digital == 0)
				
																				<div class="tab-pane fade" id="v-pills-tab{{ $gt->id }}"
																					role="tabpanel"
																					aria-labelledby="v-pills-tab{{ $gt->id }}-tab">
				
																				</div>
				
																			@endif
				
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
                            <input type="hidden" name="dp" value="{{$digital}}">
                            <input type="hidden" id="input_tax" name="tax" value="">
                            <input type="hidden" id="input_tax_type" name="tax_type" value="">
                            <input type="hidden" name="totalQty" value="{{$totalQty}}">

                            <input type="hidden" name="vendor_shipping_id" value="{{ $vendor_shipping_id }}">
                            <input type="hidden" name="vendor_packing_id" value="{{ $vendor_packing_id }}">


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
							<input type="hidden" id="ttotal" value="{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0' }}">
                            <input type="hidden" name="coupon_code" id="coupon_code" value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
                            <input type="hidden" name="coupon_discount" id="coupon_discount" value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
                            <input type="hidden" name="coupon_id" id="coupon_id" value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">



</form>


				</div>

				@if(Session::has('salescart'))
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
								class="cart-total">{{ Session::has('salescart') ? App\Models\Product::convertPrice(Session::get('salescart')->totalPrice) : '0.00' }}</b>
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
						
							<span id="total-cost">{{ App\Models\Product::convertPrice($totalPrice) }}</span>

		              </p>
		            </div>
					<div style="display:flex;" class="total-price">
						<p>
							{{ __('Shipping') }}
						</p>
						<?php
						// print_r($shipping_data['1']->price);
						?>
						<!-- <input type="hidden" class="shipping" id="free-shepping" name="shipping" value="{{ round($shipping_data['1']->price * $curr->value,2) }}" > -->
						<input type="hidden" class="shipping" id="free-shepping" name="shipping" value="0" >
						<p syle="text-align:right;">
							<span class="cart-total" id="shipping-charge">
								Free
							</span>
						</p>
						<!-- <p syle="text-align:right;">
							<span class="cart-total" id="shipping-charge">
								@if($shipping_data['1']->price != 0)
								+ {{ $curr->sign }}{{ round($shipping_data['1']->price * $curr->value,2) }}
								@endif
							</span>
						</p> -->
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

						@if($digital == 0)

						<!-- {{-- Shipping Method Area Start --}}
						<div class="packeging-area">
								<h4 class="title">{{ __('Shipping Method') }}</h4>

							@foreach($shipping_data as $data)

								<div class="radio-design">
										<input type="radio" class="shipping" id="free-shepping{{ $data->id }}" name="shipping" value="{{ round($data->price * $curr->value,2) }}" {{ ($loop->first) ? 'checked' : '' }}>
										<span class="checkmark"></span>
										<label for="free-shepping{{ $data->id }}">
												{{ $data->title }}
												@if($data->price != 0)
												+ {{ $curr->sign }}{{ round($data->price * $curr->value,2) }}
												@endif
												<small>{{ $data->subtitle }}</small>
										</label>
								</div>

							@endforeach

						</div>
						{{-- Shipping Method Area End --}} -->

						<!-- {{-- Packeging Area Start --}}
						<div class="packeging-area">
								<h4 class="title">{{ __('Packaging') }}</h4>

							@foreach($package_data as $data)

								<div class="radio-design">
										<input type="radio" class="packing" id="free-package{{ $data->id }}" name="packeging" value="{{ round($data->price * $curr->value,2) }}" {{ ($loop->first) ? 'checked' : '' }}>
										<span class="checkmark"></span>
										<label for="free-package{{ $data->id }}">
												{{ $data->title }}
												@if($data->price != 0)
												+ {{ $curr->sign }}{{ round($data->price * $curr->value,2) }}
												@endif
												<small>{{ $data->subtitle }}</small>
										</label>
								</div>

							@endforeach

						</div>
						{{-- Packeging Area End Start--}} -->

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

						@endif

				{{-- Wallet Area Start--}}

				<div class="wallet-price d-none">
					<span>{{ __('Wallet Amount:') }}</span>
					@if($gs->currency_format == 0)
						<span id="wallet-cost"></span>
					@else
						<span id="wallet-cost"></span>
					@endif
			</div>
			

			@if($user->balance >= 1)
				<div class="wallet-balace-money mt-3"><p><i class="icofont-wallet"></i> Wallet Balance: <span>{{$user->balance}}</p></div>									
				<div class="mt-3">
					<input class="styled-checkbox" id="wallet" type="checkbox" value="value1">
					<label for="wallet">{{ __('Pay From Your Wallet') }}</label>
				</div>
				<div class="wallet-box mt-3 d-none">

					<form id="wallet-form">

						@if(Session::has('coupon_total'))

						<input type="number" placeholder="{{  __('Enter Amount')}}" step="0.01" id="wallet-amount" min="1" required="" value="{{ $totalPrice <= ( $user->balance * $curr->value ) ? $totalPrice :  round($user->balance * $curr->value ,2) }}">

						@elseif(Session::has('coupon_total1'))

						<input type="number" placeholder="{{ __('Enter Amount') }}" step="0.01" id="wallet-amount" min="1" required="" value="{{ preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1')) <= ( $user->balance * $curr->value ) ? preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1')) :  round($user->balance * $curr->value ,2) }}">

						@else

						<input type="number" class="form-control" placeholder="{{ __('Enter Amount') }}" step="0.01" id="wallet-amount" min="1" required="" value="">

						@endif

						<button class="mybtn1 mt-3" type="submit">{{ __('SUBMIT') }}</button>
					</form>

				</div>
				@endif


		{{-- Wallet Area End --}}

						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</section>
		<!-- Check Out Area End-->

@if(isset($checked))


@endif

@endsection

@section('scripts')

<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script src="https://www.2checkout.com/checkout/api/2co.min.js"></script>

<script src="{{asset('assets/front/js/toastr.js')}}"></script>

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
						// tax_submit(country_id,response.state);
					}else{
						// tax_submit(country_id,state_id);
					}
					
				});
				
			}else{
				
				// tax_submit(country_id,state_id);
				hide_state();
			}

		}else{
			
			// tax_submit(country_id,state_id);
			hide_state();
		}

	});

	
	$(document).on('change','#order_type',function(){
		var order_type = $(this).val();
		if(order_type=='offline'){
			$('#main-info').addClass('d-none');
			$('#zipcode').removeAttr('required');
			$('#address').removeAttr('required');
			$('#city').removeAttr('required');
		}else{
			

			$('#zipcode').attr('required', 'required');
			$('#main-info').removeClass('d-none');
			$('#address').removeClass('d-none');
			$('#city').removeClass('d-none');
		}
	});
	$(document).on('change','#show_state',function(){
		let state_id = $(this).val();
		let country_id = $('#select_country option:selected').attr('data');
		// tax_submit(country_id,state_id);
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
					// tax_submit(country_id,response.state);
				});

			}else{
				// tax_submit(country_id,state_id);
				hide_state();
			}
		}else{
			// tax_submit(country_id,state_id);
			hide_state();
		}
	});


	

	// function tax_submit(country_id,state_id){
		
	// 	$('.gocover').show();
	// 	var total = $("#ttotal").val();
	// 	var ship = 0;
	// 	$.ajax({
    //                 type: "GET",
    //                 url:mainurl+"/country/tax/check",
    //                 data:{state_id:state_id,country_id : country_id,total:total, shipping_cost:ship},
    //                 success:function(data){
	// 						console.log(data);
	// 						$('#grandtotal').val(data[0]);
	// 						$('#tgrandtotal').val(data[0]);
	// 						$('#original_tax').val(data[1]);
	// 						$('.tax_show').removeClass('d-none');
	// 						$('#input_tax').val(data[11]);
	// 						$('#input_tax_type').val(data[12]);
	// 						$('.original_tax').html(parseFloat(data[1]).toFixed(2));
    //                         var ttotal = parseFloat($('#grandtotal').val());
    //                         var tttotal = parseFloat($('#grandtotal').val()) + (parseFloat(mship) + parseFloat(mpack));
    //                         ttotal = parseFloat(ttotal).toFixed(2);
    //                         tttotal = parseFloat(tttotal).toFixed(2);

    //                         if(pos == 0){
	// 						$('#final-cost').html('{{ $curr->sign }}'+tttotal);
	// 						$('#total-cost').html('{{ $curr->sign }}'+ttotal);
	// 							}
	// 							else{
	// 							$('#final-cost').html(tttotal+'{{ $curr->sign }}');
	// 							$('#total-cost').html(ttotal+'{{ $curr->sign }}');
	// 							}
	// 						$('.gocover').hide();
    //                   }
    //           });
	// }









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
		var user_id = $("#user_id").val();

            $.ajax({
                    type: "GET",
                    url:mainurl+"/sales/user/wallet/check",
                    data:{code:val, total:total, prev_price:prev_wallet_price, shipping_cost:shipping_cost, user_id:user_id},
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
        var ship = 0;
            $.ajax({
                    type: "GET",
                    url:mainurl+"/carts/coupon/check",
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
