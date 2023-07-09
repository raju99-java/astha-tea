@extends('layouts.sales') 

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
                                        <h4 class="heading">{{ __('Total Custom Tea Sales') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('sales.dashboard') }}">{{ __('Dashboard') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Orders') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('sales-customtea-order-index') }}">{{ __('Total Custom Tea Sales') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        @include('includes.sales.form-success') 
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
                                                    <button class="add-btn" type="button" style="margin-top:20px;padding: 10px 50px;" onclick="applyForm();">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsiv">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Customer Phone') }}</th>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{ __('Payment Type') }}</th>
                                                            <th>{{ __('Total Cost') }}</th>
                                                            <th>{{ __('Options') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>









@endsection    

@section('scripts')

{{-- DATA TABLE --}}

    <script type="text/javascript">

        var table = $('#geniustable').DataTable({
               ordering: false,
               processing: true,
               serverSide: true,
               ajax: {
                    url: "{{ route('sales-customtea-order-datatables','none') }}",
                    data: function (d) {
                        d.from_date = $('#from_date').val(),
                        d.to_date = $('#to_date').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
            //    ajax: '{{ route('admin-order-datatables','none') }}',
                columns: [
                        { data: 'customer_phone', name: 'customer_phone' },
                        { data: 'order_number', name: 'order_number' },
                        { data: 'method', name: 'method' },
                        { data: 'pay_amount', name: 'pay_amount' },
                        { data: 'action', searchable: false, orderable: false }
                     ],
                language : {
                    processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
                drawCallback : function( settings ) {
                        $('.select').niceSelect();  
                }
            });
            function applyForm(){
                
                table.draw();
            }                                                   
    </script>

{{-- DATA TABLE --}}
    
@endsection   