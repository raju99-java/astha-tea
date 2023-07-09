<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{$seo->meta_keys}}">
        <meta name="author" content="GeniusOcean">

        <title>{{$gs->title}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('assets/print/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/print/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/print/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/print/css/style.css')}}">
  <link href="{{asset('assets/print/css/print.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
  <style type="text/css">

#color-bar {
  display: inline-block;
  width: 20px;
  height: 20px;
  margin-left: 5px;
  margin-top: 5px;
}

@page { size: auto;  margin: 0mm; }
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 287mm;
  }

html {
    overflow: scroll;
    overflow-x: hidden;
}
::-webkit-scrollbar {
    width: 0px;  /* remove scrollbar space */
    background: transparent;  /* optional: just make scrollbar invisible */
}
  </style>
</head>
<body onload="window.print();">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                    <div class="product__header">
                                        <div class="row reorder-xs">
                                            <div class="col-lg-8 col-md-5 col-sm-5 col-xs-12">
                                                <div class="product-header-title">
                                                    <h2>{{ __('Order#') }} {{$order->order_number}} [{{$order->status}}]</h2>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="dashboard-content">
                                                    <div class="view-order-page" id="print">
                                                        <p class="order-date" style="margin-left: 2%">{{ __('Order Date') }} {{date('d-M-Y',strtotime($order->created_at))}}</p>


@if($order->dp == 1)

                                                        <div class="billing-add-area">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h5>{{__('Billing Address') }}</h5>
                                                                    <address>
                                                                        {{ __('Name') }} {{$order->customer_name}}<br>
                                                                        {{ __('Email') }} {{$order->customer_email}}<br>
                                                                        {{ __('Phone') }} {{$order->customer_phone}}<br>
                                                                        {{__('Address') }} {{$order->customer_address}}<br>
                                                                        {{$order->customer_city}}-{{$order->customer_zip}}
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h5>{{__('Payment Information') }}</h5>
                                                                    <p>{{ __('Paid Amount') }} {{$order->currency_sign}}{{ round(($order->pay_amount + $order->wallet_price) * $order->currency_value , 2) }}</p>
                                                                    <p>{{ __('Payment Method') }} {{$order->method}}</p>

                                                                    @if($order->method != "Cash On Delivery")
                                                                        @if($order->method=="Stripe")
                                                                            {{$order->method}} {{ __('Charge ID') }} <p>{{$order->charge_id}}</p>
                                                                        @endif
                                                                        {{$order->method}} {{ __('Transaction ID') }} <p id="ttn">{{$order->txnid}}</p>

                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

@else
                                                            <div class="invoice__metaInfo">

                                                                <div class="col-md-6">
                                                                    <h5>{{ __('Billing Address') }}</h5>
                                                                    <address>
                                                                        {{ __('Name') }} {{$order->customer_name}}<br>
                                                                        {{ __('Email') }} {{$order->customer_email}}<br>
                                                                        {{ __('Phone') }} {{$order->customer_phone}}<br>
                                                                        {{ __('Address') }} {{$order->customer_address}}<br>
                                                                        {{$order->customer_city}}-{{$order->customer_zip}}
                                                                    </address>

                                                                    <h5>{{__('Payment Information') }}</h5>
                                                                    <p>{{ __('Paid Amount') }} {{$order->currency_sign}}{{ round(($order->pay_amount + $order->wallet_price) * $order->currency_value , 2) }}</p>
                                                                    <p>{{ __('Payment Method') }} {{$order->method}}</p>

                                                                    @if($order->method != "Cash On Delivery")
                                                                        @if($order->method=="Stripe")
                                                                            {{$order->method}} {{ __('Charge ID') }} <p>{{$order->charge_id}}</p>
                                                                        @endif
                                                                        {{$order->method}} {{ __('Transaction ID') }} <p id="ttn">{{$order->txnid}}</p>

                                                                    @endif


                                                                </div>

                                                                <div class="col-md-6" style="width: 50%;">
                                                                    @if($order->shipping == "shipto")
                                                                        <h5>{{ __('Shipping Address') }}</h5>
                                                                        <address>
                {{ __('Name') }} {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                {{__('Email') }} {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                {{__('Phone')}} {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                {{ __('Address') }} {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
{{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                                                        </address>
                                                                    @else
                                                                        <h5>{{ __('PickUp Location') }}</h5>
                                                                        <address>
                                                                            {{ __('Address') }} {{$order->pickup_location}}<br>
                                                                        </address>
                                                                    @endif

                                                                    <h5>{{ __('Shipping Method') }}</h5>
                                                                    @if($order->shipping == "shipto")
                                                                        <p>{{ __('Ship To Address') }}</p>
                                                                    @else
                                                                        <p>{{__('Pick Up') }}</p>
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

@endif
                                                        <br>
                                                        <br>
                                                        <div class="table-responsive">
                            <table id="example" class="table">
                                <h4 class="text-center">{{ __('Ordered Products') }}</h4><hr>
                                <thead>
                                <tr>
                                    <th width="60%">{{ __('Component Name') }}</th>
                                    <th width="20%">{{ __('weight (gm)') }}</th>
                                    <th width="10%">{{ __('Price (INR)') }}</th>
                                </tr>
                                </thead>
                                @php
                                    $smellProduct=App\Models\CustomTea::where('type','=','1')->where('id',$order->p1)->first();
                                    $colorProduct=App\Models\CustomTea::where('type','=','2')->where('id',$order->p2)->first();
                                @endphp
                                <tbody>
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
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>
<!-- ./wrapper -->
<!-- ./wrapper -->

<script type="text/javascript">
setTimeout(function () {
        window.close();
      }, 500);
</script>
</body>
</html>
