@extends('layouts.sales') 

@section('styles')

<style type="text/css">
    
.input-field { 
    padding: 15px 20px; 
}
.btn-home {
    background: #4d9325;
    padding: 10px 30px !important;
    color: #fff !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    border-radius: 50px !important;
}
.body-area p {
    font-size: 30px;
    line-height: 30px;
    font-weight: 600;
    letter-spacing: normal;
    color: #4d9325;
    margin-top: 30px;
    margin-bottom: 0px;
}
.product-description{
    box-shadow: -2px -1px 12px -4px rgb(0 0 0 / 75%);
    border: 2px solid #4d9325;
    background: #fff;
    padding: 50px 0px;
    margin-top: 2rem;
}
</style>

@endsection

@section('content')  



<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                    <h4 class="heading">{{ __('All Orders') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('sales.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Custom Tea Orders') }}</a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Confirm Order') }}</a>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="product-description text-center">
                    <div class="body-area">
                        <p>Order Placed Successfully</p>
                    </div>
                    <div class="back-button text-center mt-4"><a href="{{ route('sales-customtea-order-create') }}" class="btn btn-home">Create A New Order</a></div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection    

@section('scripts')


    
@endsection   