@extends('layouts.front')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/front/css/user.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/datatables.css')}}">
@endsection
@section('content')
<!-- <section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-title-div">
                    <div class="bread-left-side">
                        <h2>Dashboard</h2>
                    </div>
                    <div class="breadcrumb-ul right-side">
                        <ul>
                        <li><a href="{{ route('front.index') }}">HOME</a>/</li>
                        <li>
                          <a href="{{ route('user-dashboard') }}">
                            {{ __('Dashboard') }}
                          </a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
          @include('includes.form-success')
          <div class="row mb-3">
            @if(!empty($usercustomtea))
            @php
              $smellProduct=App\Models\CustomTea::where('type','=','1')->where('id',$usercustomtea->smell)->first();
              $colorProduct=App\Models\CustomTea::where('type','=','2')->where('id',$usercustomtea->color)->first();
              $colorper=$usercustomtea->weight*($usercustomtea->color_per/100);
              $smellper=$usercustomtea->weight*($usercustomtea->smell_per/100);
              $colorprice=$colorper*$colorProduct->price;
              $smellprice=$smellper*$smellProduct->price;
            @endphp
            <div class="col-lg-6">
              <div class="user-profile-details">
                <div class="account-info">
                  <div class="header-area">
                    <h4 class="title">
                      {{__('Smell Component') }}
                    </h4>
                  </div>
                  <div class="edit-info-area">
                  </div>
                  <div class="main-info">
                    <h5 class="title">{{$smellProduct->name}}</h5>
                    <ul class="list">
                      <li>
                        <p><span class="user-title">{{ __('Price')}}</span> ₹{{$smellprice}}</p>
                      </li>
                      <li>
                        <p><span class="user-title">{{ __('Weight(gm)') }}</span> {{$smellper}}</p>
                      </li>
                      <li>
                        <p><span class="user-title">{{ __('Percentage') }}</span> {{$usercustomtea->smell_per}}%</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="user-profile-details">
                <div class="account-info">
                  <div class="header-area">
                    <h4 class="title">
                      {{__('Colour Component') }}
                    </h4>
                  </div>
                  <div class="edit-info-area">
                  </div>
                  <div class="main-info">
                    <h5 class="title">{{$colorProduct->name}}</h5>
                    <ul class="list">
                      <li>
                        <p><span class="user-title">{{ __('Price')}}</span> ₹{{$colorprice}}</p>
                      </li>
                      <li>
                        <p><span class="user-title">{{ __('Weight(gm)') }}</span> {{$colorper}}</p>
                      </li>
                      <li>
                        <p><span class="user-title">{{ __('Percentage') }}</span> {{$usercustomtea->color_per}}%</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="dual-button">
                <a href="{{route('front.customtea')}}" class="btn btn-dual-one">Change Your Tea Composition</a>
                <a href="{{route('front.customteacheckout')}}" class="btn btn-dual-two">Order Existing Tea Composition</a>
              </div>
            </div>  
            @else

            <div class="col-sm-10 offset-sm-1">
              <div class="total-sms-box">
                <div class="message-boxes">
                  <h6>No Custom Tea Composition Created</h6>
                </div>
                <div class="message-boxes-btn">
                  <a href="{{route('front.customtea')}}" class="btn btn-create">Click Here To Create Composition</a>
                </div>
              </div>  
            </div>


            @endif
        </div>




        <div class="row">
        
        </div>
      </div>
      </div>
    </div>
  </section>



@endsection

@section('scripts')
<script src="{{asset('assets/front/js/datatables.js')}}"></script>
@endsection