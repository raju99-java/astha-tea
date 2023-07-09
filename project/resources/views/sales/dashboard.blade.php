@extends('layouts.sales')

@section('content')
<div class="content-area">
    @include('includes.form-success')

    @if($activation_notify != "")
    <div class="alert alert-danger validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <h3 class="text-center">{!! $activation_notify !!}</h3>
    </div>
    @endif
    
    @if(Session::has('cache'))

    <div class="alert alert-success validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <h3 class="text-center">{{ Session::get("cache") }}</h3>
    </div>


  @endif



    <div class="row row-cards-one">
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg1">
                <div class="left">
                    <h5 class="title">{{ __(' Total registered users') }}</h5>
                    <span class="number">{{count($users)}}</span>
                    <a href="{{route('sales-user-registered')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg2">
                <div class="left">
                    <h5 class="title">{{ __('Total Sales !') }}<br/>Today</h5>
                    <span class="number">{{$total_sales_day}}</span>
                    <a href="{{route('sales-order-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-truck-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg3">
                <div class="left">
                    <h5 class="title">{{ __('Total Sales This Month!') }}</h5>
                    <span class="number">{{$total_sales_monthly}}</span>
                    <a href="{{route('sales-order-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-truck-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg4">
                <div class="left">
                    <h5 class="title">{{ __('Total Sales As Of Now!') }}</h5>
                    <span class="number">{{$total_sales}}</span>
                    <a href="{{route('sales-order-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-truck-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg5">
                <div class="left">
                    <h5 class="title">{{ __('Total Custom Tea Sales Today!') }}</h5>
                    <span class="number">{{$total_customtea_sales_day}}</span>
                    <a href="{{route('sales-customtea-order-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-truck-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg6">
                <div class="left">
                    <h5 class="title">{{ __('Total Custom Tea Sales This Month!') }}</h5>
                    <span class="number">{{$total_customtea_sales_monthly}}</span>
                    <a href="{{route('sales-customtea-order-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-truck-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg1">
                <div class="left">
                    <h5 class="title">{{ __('Total Custom Tea Sales As Of Now!') }}</h5>
                    <span class="number">{{$total_customtea_sales}}</span>
                    <a href="{{route('sales-customtea-order-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-truck-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        
        


    </div>

    <!-- <audio id="mySound" src="{{asset('assets/sound/beep.mp3')}}" webkit-playsinline="true" playsinline="true" autoplay="true"></audio> -->

@endsection

@section('scripts')

<script language="JavaScript">
    
    
    
    
    // setInterval(function() { 
    //     $.ajax({
    //    method:"GET",
    //    url:"{{ route('delivery.check-delivery-order') }}",
    //    dataType:'JSON',
    //    contentType: false,
    //    cache: false,
    //    processData: false,
    //    success:function(data)
    //    {
    //     // alert(data.status);
    //     // document.getElementById('mySound').play();
    //    }
    //   });
          
    // }, 1000);
</script>



@endsection