<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{$seo->meta_keys}}">
    <meta name="author" content="Astha Tea">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{$gs->title}}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
    <style>
        * {
            font-size: 12px;
            font-family: 'Times New Roman';
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }

        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 155px;
            max-width: 155px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        @media print {
            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
    </head>
    <body onload="window.print();">
        <div class="ticket">
            <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="Logo">
			<div class="col-lg-6">
                <div class="invoice__orderDetails">
                    
                    <p><strong>{{ __('Order Details') }} </strong></p>
                    <span><strong>{{ __('Invoice Number') }} :</strong> {{ sprintf("%'.08d", $order->id) }}</span><br>
                    <span><strong>{{ __('Order Date') }} :</strong> {{ date('d-M-Y',strtotime($order->created_at)) }}</span><br>
                    <span><strong>{{  __('Order ID')}} :</strong> {{ $order->order_number }}</span><br>
                    <!-- @if($order->dp == 0)
                    <span> <strong>{{ __('Shipping Method') }} :</strong>
                        @if($order->shipping == "pickup")
                        {{ __('Pick Up') }}
                        @else
                        {{ __('Ship To Address') }}
                        @endif
                    </span><br>
                    @endif -->
                    <span> <strong>{{ __('Payment Method') }} :</strong> {{$order->method}}</span>
                </div>
            </div>
            <div class="invoice__metaInfo" style="margin-top:0px;">
                @if($order->dp == 0)
                <!-- <div class="col-lg-6">
                        <div class="invoice__orderDetails" style="margin-top:5px;">
                            <p><strong>{{ __('Shipping Details') }}</strong></p>
                           <span><strong>{{ __('Customer Name') }}</strong>: {{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</span><br>
                           <span><strong>{{ __('Address') }}</strong>: {{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}</span><br>
                           <span><strong>{{ __('City') }}</strong>: {{ $order->shipping_city == null ? $order->customer_city : $order->shipping_city }}</span><br>
                           <span><strong>{{ __('Country') }}</strong>: {{ $order->shipping_country == null ? $order->customer_country : $order->shipping_country }}</span>
                        </div>
                </div> -->
                @endif
                <div class="col-lg-6" style="width:50%;">
                        <div class="invoice__orderDetails" style="margin-top:5px;">
                            <p><strong>{{ __('Billing Details') }}</strong></p>
                            <span><strong>{{ __('Customer Name') }}</strong>: {{ $order->customer_name}}</span><br>
                            <span><strong>{{ __('Address') }}</strong>: {{ $order->customer_address }}</span><br>
                            <span><strong>{{ __('City') }}</strong>: {{ $order->customer_city }}</span><br>
                            <span><strong>{{ __('Country') }}</strong>: {{ $order->customer_country }}</span>
                        </div>
                </div>
            </div>
            <p class="centered"></p>
            <table>
                <thead>
                    <tr>
                        <th class="description">Product</th>
                        <th class="quantity">Details</th>
                        <th class="price">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $subtotal = 0;
                    $tax = 0;
                    @endphp
                    @foreach($cart['items'] as $product)
                    <tr>
                        <td class="description">
                            @if($product['item']['user_id'] != 0)
                            @php
                            $user = App\Models\User::find($product['item']['user_id']);
                            @endphp
                            @if(isset($user))
                            {{ $product['item']['name']}}
                            @else
                            {{$product['item']['name']}}
                            @endif

                            @else
                            {{ $product['item']['name']}}
                            @endif
                        </td>
                        <td class="quantity">
                        @if($product['size'])
                        <p>
                            <strong>{{ __('Size') }} :</strong> {{str_replace('-',' ',$product['size'])}}
                        </p>
                        @endif
                        @if($product['color'])
                        <p>
                                <strong>{{ __('color') }} :</strong> <span style="width: 20px; height: 5px; display: block; border: 10px solid {{$product['color'] == "" ? "white" : '#'.$product['color']}};"></span>
                        </p>
                        @endif
                        <p>
                                <strong>{{ __('Price') }} :</strong> {{$order->currency_sign}}{{ round($product['item_price'] * $order->currency_value , 2) }}
                        </p>
                        <p>
                            <strong>{{ __('Qty') }} :</strong> {{$product['qty']}} {{ $product['item']['measure'] }}
                        </p>


                        @if(!empty($product['keys']))

                            @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
                            <p>

                                <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} 

                            </p>
                            @endforeach

                        @endif
                        </td>
                        
                        <td class="price">{{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}</td>
                    </tr>
                    @php
                    $subtotal += round($product['price'] * $order->currency_value, 2);
                    @endphp
                    @endforeach
                    <tr class="semi-border">
                        <td colspan="1"></td>
                        <td><strong>{{ __('Subtotal') }}</strong></td>
                        <td>{{$order->currency_sign}}{{ round($subtotal, 2) }}</td>

                    </tr>
                    @if($order->shipping_cost != 0)
                        @php 
                        $price = round(($order->shipping_cost / $order->currency_value),2);
                        @endphp
                        @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                        <tr class="no-border">
                            <td colspan="1"></td>
                            <td><strong>{{ DB::table('shippings')->where('price','=',$price)->first()->title }}({{$order->currency_sign}})</strong></td>
                            <td>{{ round($order->shipping_cost , 2) }}</td>
                        </tr>
                        @endif
                    @endif
                    @if($order->packing_cost != 0)
                    @php 
                    $pprice = round(($order->packing_cost / $order->currency_value),2);
                    @endphp
                    @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                    <tr class="no-border">
                        <td colspan="1"></td>
                        <td><strong>{{ DB::table('packages')->where('price','=',$pprice)->first()->title }}({{$order->currency_sign}})</strong></td>
                        <td>{{ round($order->packing_cost , 2) }}</td>
                    </tr>
                    @endif
                    @endif

                    @if($order->tax != 0)
                    <tr class="no-border">
                        <td colspan="1"></td>
                        <td><strong>{{ __('TAX') }}({{$order->currency_sign}})</strong></td>

                        @php
                        $tax = ($subtotal / 100) * $order->tax;
                        @endphp

                        <td>{{round($tax, 2)}}</td>
                    </tr>

                    @endif
                    @if($order->coupon_discount != null)
                    <tr class="no-border">
                        <td colspan="1"></td>
                        <td><strong>{{ __('Coupon Discount') }}({{$order->currency_sign}})</strong></td>
                        <td>{{$order->currency_sign}}{{round($order->coupon_discount, 2)}}</td>
                    </tr>
                    @endif

                    @if($order->wallet_price != 0)
                    <tr class="no-border">
                        <td colspan="1"></td>
                        <td><strong>{{ __('Paid From Wallet') }}</strong></td>
                        <td>{{$order->currency_sign}}{{ round($order->wallet_price * $order->currency_value , 2) }}</td>
                    </tr>
                        @if($order->method != "Wallet")
                        <tr class="no-border">
                            <td colspan="1"></td>
                            <td><strong>{{$order->method}}</strong></td>
                            <td>{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                            </td>
                        </tr>
                        @endif

                    @endif
                    <tr class="final-border">
                        <td colspan="1"></td>
                        <td><strong>{{ __('Total') }}</strong></td>
                        <td>{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                        </td>
                    </tr>

                </tbody>
            </table>
            <p class="centered">Thanks for your purchase!
                <br>asthatea.com</p>
        </div>
        <script type="text/javascript">
        setTimeout(function () {
                window.close();
            }, 500);
        </script>
       
		
    </body>
</html>