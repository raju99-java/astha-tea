@extends('layouts.front')


@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/checkout.css')}}">
@endsection


@section('content')

<!-- Breadcrumb Area Start -->

<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-title-div">
                    <div class="bread-left-side">
                        <h2>Success</h2>
                    </div>
                    <div class="breadcrumb-ul right-side">
                        <ul>
                        <li><a href="{{ route('front.index') }}">HOME</a>/</li>
                        <li>
                            <a href="{{ route('customteapayment.return') }}">
                            {{ __('Success') }}
                            </a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Area End -->






<section class="tempcart">



        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="content-box section-padding add-product-1">
                        <div class="top-area">
                                <div class="content">
                                    <h4 class="heading">
                                        {{ __('THANK YOU FOR YOUR PURCHASE.') }}
                                    </h4>
                                    <p class="text">
                                        {{ __("We'll email you an order confirmation with details and tracking info.") }}
                                    </p>
                                    <a href="{{ route('front.index') }}" class="link">{{ __('Get Back To Our Homepage') }}</a>
                                  </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">

                                    <div class="product__header">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-12">
                                                <div class="product-header-title">
                                                    <h2>{{ __('Order#') }} {{$order->order_number}}</h2>
                                        </div>
                                    </div>
                                        @include('includes.form-success')
                                            <div class="col-md-12" id="tempview">
                                                <div class="dashboard-content">
                                                    <div class="view-order-page" id="print">
                                                        <p class="order-date">{{ __('Order Date') }} {{date('d-M-Y',strtotime($order->created_at))}}</p>


@if($order->dp == 1)

                                                        <div class="billing-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>{{ __('Billing Address') }}</h5>
                                                                    <address>
                                                                        {{ __('Name:') }} {{$order->customer_name}}<br>
                                                                        {{ __('Email:') }} {{$order->customer_email}}<br>
                                                                        {{ __('Phone:') }} {{$order->customer_phone}}<br>
                                                                        {{ __('Address:') }} {{$order->customer_address}}<br>
                                                                        {{$order->customer_city}}-{{$order->customer_zip}}
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>{{ __('Payment Information') }}</h5>
                                                                    <p>{{ __('Paid Amount:') }} {{$order->currency_sign}}{{ round(($order->pay_amount + $order->wallet_price) * $order->currency_value , 2) }}</p>
                                                                    <p>{{ __('Total Earning') }} (<b>{{$order->tax_location}}</b>) :  {{$order->currency_sign}}{{$order->tax}}</p>
                                                                    <p>{{ __('Payment Method:') }} {{$order->method}}</p>

                                                                    @if($order->method != "Cash On Delivery")
                                                                        @if($order->method=="Stripe")
                                                                            {{$order->method}} {{ __('Charge ID:') }} <p>{{$order->charge_id}}</p>
                                                                        @endif
                                                                        {{$order->method}} {{ __('Transaction ID:') }} {{$order->txnid}} <p id="ttn">{{$order->txnid}}</p>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

@else
                                                        <div class="shipping-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @if($order->shipping == "shipto")
                                                                        <h5>{{ __('Shipping Address') }}</h5>
                                                                        <address>
                {{ __('Name:') }} {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                {{__('Email:') }} {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                {{ __('Phone:') }} {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                {{ __('Address:') }} {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
{{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                                                        </address>
                                                                    @else
                                                                        <h5>{{ __('PickUp Location') }}</h5>
                                                                        <address>
                                                                            {{ __('Address:') }} {{$order->pickup_location}}<br>
                                                                        </address>
                                                                    @endif

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>{{ __('Shipping Method') }}</h5>
                                                                    @if($order->shipping == "shipto")
                                                                        <p>{{ __('Ship To Address') }}</p>
                                                                    @else
                                                                        <p>{{ __('Pick Up') }}</p>
                                                                    @endif
                                                                    @if($order->shipping_cost != 0)
                                                                        @php
                                                                        $price = round(($order->shipping_cost / $order->currency_value),2);
                                                                        @endphp
                                                                        @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                                                                <p>
                                                                    {{ DB::table('shippings')->where('price','=',$price)->first()->title }}: {{$order->currency_sign}}{{ round($order->shipping_cost, 2) }}
                                                                </p>
                                                                        @endif
                                                                    @endif

                                                                    @if($order->packing_cost != 0)

                                                                        @php
                                                                        $pprice = round(($order->packing_cost / $order->currency_value),2);
                                                                        @endphp


                                                                        @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                                                                <p>
                                                                    {{ DB::table('packages')->where('price','=',$pprice)->first()->title }}: {{$order->currency_sign}}{{ round($order->packing_cost, 2) }}
                                                                </p>
                                                                        @endif
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="billing-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>{{ __('Billing Address') }}</h5>
                                                                    <address>
                                                                        {{ __('Name:') }} {{$order->customer_name}}<br>
                                                                        {{__('Email:') }} {{$order->customer_email}}<br>
                                                                        {{ __('Phone:') }} {{$order->customer_phone}}<br>
                                                                        {{ __('Address:') }} {{$order->customer_address}}<br>
                                                                        {{$order->customer_city}}-{{$order->customer_zip}}
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>{{ __('Payment Information') }}</h5>
                                                                    <p>{{__('Paid Amount:') }} {{$order->currency_sign}}{{ round(($order->pay_amount + $order->wallet_price) * $order->currency_value , 2) }}</p>
                                                                    <!-- <p>{{ __('Tax') }} (<b>{{$order->tax_location}}</b>) :  {{$order->currency_sign}}{{$order->tax}}</p> -->
                                                                    <p>{{__('Payment Method:') }} {{$order->method}}</p>

                                                                    @if($order->method != "Cash On Delivery")
                                                                       
                                                                        {{$order->method}} {{ __('Transaction ID:') }} <p id="ttn">{{$order->txnid}}</p>
                                                                      
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
@endif
                                                        <br>
                                                        <div class="table-responsive">
                            <table  class="table">
                                <h4 class="text-center">{{__('Ordered Products:') }}</h4>
                                <thead>
                                <tr>

                                    <th width="60%">{{ __('Component Name') }}</th>
                                    <th width="20%">{{ __('weight (gm)') }}</th>
                                    <th width="10%">{{ __('Price (INR)') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $smellProduct=App\Models\CustomTea::where('type','=','1')->where('id',$order->p1)->first();
                                    $colorProduct=App\Models\CustomTea::where('type','=','2')->where('id',$order->p2)->first();
                                    @endphp
                                
                                    <tr>

                                            <td>{{$smellProduct->name}}</td>
                                            <td>{{$order->p1_weight}}</td>
                                            <td>{{$order->p1_price}}</td>

                                    </tr>
                                    <tr>

                                            <td>{{$colorProduct->name}}</td>
                                            <td>{{$order->p2_weight}}</td>
                                            <td>{{$order->p2_price}}</td>

                                    </tr>



                                </tbody>
                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>



  </section>

@endsection
