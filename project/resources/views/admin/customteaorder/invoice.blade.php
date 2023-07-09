@extends('layouts.admin')

@section('content')
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Order Invoice') }} <a class="add-btn" href="javascript:history.back();"><i
                            class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Custom Tea Orders') }}</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Invoice') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="order-table-wrap">
        <div class="invoice-wrap">
            <div class="invoice__title">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="invoice__logo text-left">
                           <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo" style="height:100px; width:150px;">
                        </div>
                    </div>
                    <div class="col-lg-3 text-right">
                        <a class="btn  add-newProduct-btn print" href="{{route('admin-customtea-order-thermal-print',$order->id)}}"
                        target="_blank"><i class="fa fa-print"></i> {{ __('Thermal Print') }}</a>
                    </div>
                    <div class="col-lg-3 text-right">
                        <a class="btn  add-newProduct-btn print" href="{{route('admin-customtea-order-print',$order->id)}}"
                        target="_blank"><i class="fa fa-print"></i> {{ __('Print Invoice') }}</a>
                    </div>
                </div>
            </div>
            <br>
            <div class="row invoice__metaInfo mb-4">
                <div class="col-lg-6">
                    <div class="invoice__orderDetails">
                        
                        <p><strong>{{ __('Order Details') }} </strong></p>
                        <span><strong>{{ __('Invoice Number') }} :</strong> {{ sprintf("%'.08d", $order->id) }}</span><br>
                        <span><strong>{{ __('Order Date') }} :</strong> {{ date('d-M-Y',strtotime($order->created_at)) }}</span><br>
                        <span><strong>{{  __('Order ID')}} :</strong> {{ $order->order_number }}</span><br>
                        
                        <span> <strong>{{ __('Payment Method') }} :</strong> {{$order->method}}</span>
                    </div>
                </div>
            </div>
            <div class="row invoice__metaInfo">
           @if($order->dp == 0)
                <div class="col-lg-6">
                        <div class="invoice__shipping">
                            <p><strong>{{ __('Shipping Address') }}</strong></p>
                           <span><strong>{{ __('Customer Name') }}</strong>: {{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</span><br>
                           <span><strong>{{ __('Address') }}</strong>: {{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}</span><br>
                           <span><strong>{{ __('City') }}</strong>: {{ $order->shipping_city == null ? $order->customer_city : $order->shipping_city }}</span><br>
                           <span><strong>{{ __('Country') }}</strong>: {{ $order->shipping_country == null ? $order->customer_country : $order->shipping_country }}</span>

                        </div>
                </div>

            @endif

                <div class="col-lg-6">
                        <div class="buyer">
                            <p><strong>{{ __('Billing Details') }}</strong></p>
                            <span><strong>{{ __('Customer Name') }}</strong>: {{ $order->customer_name}}</span><br>
                            <span><strong>{{ __('Address') }}</strong>: {{ $order->customer_address }}</span><br>
                            <span><strong>{{ __('City') }}</strong>: {{ $order->customer_city }}</span><br>
                            <span><strong>{{ __('Country') }}</strong>: {{ $order->customer_country }}</span>
                        </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="invoice_table">
                        <div class="mr-table">
                            <div class="table-responsive">
                                <table id="example2" class="table table-hover dt-responsive" cellspacing="0"
                                    width="100%" >
                                    <thead>
                                        <tr>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Details') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $subtotal = $order->total_price ;
                                        $tax = 0;
                                        @endphp
                                        
                                        <tr>
                                            <td width="50%">
                                                <p>{{$order->smell->name}} ({{$order->p1_weight}} gm)</p>
                                                <p>{{$order->colour->name}} ({{$order->p2_weight}} gm)</p>
                                            </td>


                                            <td>
                                                
                                                <p>
                                                        <strong>{{ __('Price') }} :</strong> {{$order->currency_sign}}{{ round($order->total_price * $order->currency_value , 2) }}
                                                </p>
                                                <p>
                                                        <strong>{{ __('Total Weight') }} :</strong> {{$order->totalweight}}
                                                </p> 
                                               
                                            </td>

                                            

                                        </tr>

                                        
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="2">{{ __('Subtotal (Including GST*)') }}</td>
                                            <td>{{$order->currency_sign}}{{ round($subtotal, 2) }}</td>
                                        </tr>
                                        @if($order->shipping_cost != 0)
                                        @php 
                                        $price = round(($order->shipping_cost / $order->currency_value),2);
                                        @endphp
                                        <tr>
                                            <td colspan="2">{{ __('Shipping Price (Including GST*)') }}</td>
                                            <td>{{$order->currency_sign}}{{ round($price, 2) }}</td>
                                        </tr>
                                        @endif

                                        

                                       
                                        @if($order->coupon_discount != null)
                                        <tr>
                                            <td colspan="2">{{ __('Coupon Discount') }}({{$order->currency_sign}})</td>
                                            <td>{{round($order->coupon_discount, 2)}}</td>
                                        </tr>
                                        @endif
                                        @if($order->wallet_price != 0)
                                        <tr>
                                            <td colspan="1"></td>
                                            <td>{{ __('Paid From Wallet') }}</td>
                                            <td>{{$order->currency_sign}}{{ round($order->wallet_price * $order->currency_value , 2) }}
                                            </td>
                                        </tr>
                                            @if($order->method != "Wallet")
                                            <tr>
                                                <td colspan="1"></td>
                                                <td>{{$order->method}}</td>
                                                <td>{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                                </td>
                                            </tr>
                                            @endif
                                        @endif

                                        <tr>
                                            <td colspan="1"></td>
                                            <td>{{ __('Total') }}</td>
                                            <td>{{$order->currency_sign}}{{ round(($order->total_price + $order->shipping_cost) * $order->currency_value , 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content Area End -->
</div>
</div>
</div>

@endsection