@extends('layouts.delivery')

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
                    <h5 class="title">{{ __(' Orders') }} <br/> Pending!</h5>
                    <span class="number">{{count($pending)}}</span>
                    <a href="{{route('delivery-order-pending')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg2">
                <div class="left">
                    <h5 class="title">{{ __('Custom Tea Orders Pending!') }}</h5>
                    <span class="number">{{count($custom_tea_pending)}}</span>
                    <a href="{{route('delivery-customtea-order-pending')}}" class="link">{{ __('View All') }}</a>
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
                    <h5 class="title">{{ __('Orders Completed!') }}</h5>
                    <span class="number">{{count($completed)}}</span>
                    <a href="{{route('delivery-order-completed')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-check-circled"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg4">
                <div class="left">
                    <h5 class="title">{{ __('Custom Tea Orders Completed!') }}</h5>
                    <span class="number">{{count($custom_tea_completed)}}</span>
                    <a href="{{route('delivery-customtea-order-completed')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-cart-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg5">
                <div class="left">
                    <h5 class="title">{{ __('Total Collection Amount') }}</h5>
                    <span class="number">{{Auth::guard('delivery')->user()->collection_amount}}</span>
                    <!-- <a href="{{route('admin-prod-index')}}" class="link">{{ __('View All') }}</a> -->
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-rupee"></i>
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