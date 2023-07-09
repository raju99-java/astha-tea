@extends('layouts.admin') 

@section('styles')

<style type="text/css">
    
.input-field { 
    padding: 15px 20px; 
}

</style>

@endsection

@section('content')  

<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __('All Orders') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Custom Tea Orders') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-customtea-total-sold-order') }}">{{ __('Total Sold Orders') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        <form id="totalsoldformdata" action="{{route('admin-customtea-total-sold-order-count')}}" method="POST" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            @include('includes.admin.form-both')
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><strong>From Date :</strong></label>
                                                        <input type="date" class="form-control form-control-sm" id="from_date" name="from_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label><strong>To Date :</strong></label>
                                                        <input type="date" class="form-control form-control-sm" id="to_date" name="to_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <button class="add-btn totalSoldSubmit-btn" type="submit" style="margin-top:20px;padding: 10px 50px;" >Apply</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="show_total_order" class="d-none">
                                        <div class="row row-cards-one">
                                            <div class="col-md-12 col-lg-6 col-xl-6">
                                                <div class="mycard bg2">
                                                    <div class="left">
                                                        <h5 class="title">{{ __('Total Sales!') }}</h5>
                                                        <span class="number" id="total_sales">0</span>
                                                    </div>
                                                    <div class="right d-flex align-self-center">
                                                        <div class="icon">
                                                            <i class="icofont-truck-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 col-xl-6">
                                                <div class="mycard bg3">
                                                    <div class="left">
                                                        <h5 class="title">{{ __('Total Sold!') }}</h5>
                                                        <span class="number" id="total_sold">0</span>
                                                    </div>
                                                    <div class="right d-flex align-self-center">
                                                        <div class="icon">
                                                            <i class="icofont-truck-alt"></i>
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



@endsection    

@section('scripts')


    
@endsection   