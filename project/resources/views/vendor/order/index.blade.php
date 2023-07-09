@extends('layouts.vendor')

@section('content')
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{__('All Orders') }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('vendor-dashboard') }}">{{ __('Dashbord') }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __('Orders') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('vendor-order-index') }}">{{ __('All Orders') }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-area">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        @include('includes.form-success')

                                        <div class="table-responsiv">
                                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Order Number') }}</th>
                                                            <th>{{__('Total Qty') }}</th>
                                                            <th>{{ __('Total Cost') }}</th>
                                                            <th>{{ __('Payment Method') }}</th>
                                                            <th>{{ __('Actions') }}</th>
                                                        </tr>
                                                    </thead>


                                              <tbody>
                                                @foreach($orders as $orderr)
                                                @php
                                                $qty = $orderr->sum('qty');
                                                $price = $orderr->sum('price');
                                                @endphp
                    @foreach($orderr as $order)


                            @php

                            if($user->shipping_cost != 0){
                                $price +=  round($user->shipping_cost * $order->order->currency_value , 2);
                                }

                                $order_info = App\Models\Order::where('order_number','=',$order->order->order_number)->first();

                            if(isset($order_info->tax) && App\Models\Order::where('order_number','=',$order->order->order_number)->first()->tax != 0){
                                $price  += ($price / 100) * App\Models\Order::where('order_number','=',$order->order->order_number)->first()->tax;
                                }

                            @endphp
                                <tr>
                                    <td> <a href="{{route('vendor-order-invoice',$order->order_number)}}">{{ $order->order->order_number}}</a></td>
                                          <td>{{$qty}}</td>
                                      <td>{{$order->order->currency_sign}}{{round($price * $order->order->currency_value, 2)}}</td>
                                      <td>{{$order->order->method}}</td>
                                      <td>

                                        <div class="action-list">

                                        <a href="{{route('vendor-order-show',$order->order->order_number)}}" class="btn btn-primary product-btn"><i class="fa fa-eye"></i> {{ __('Details') }}</a>
                                            <select class="vendor-btn {{ $order->status }}">
                                            <option value="{{ route('vendor-order-status',[ $order->order->order_number,  'pending']) }}" {{  $order->status == "pending" ? 'selected' : ''  }}>{{ __('Pending') }}</option>
                                            <option value="{{ route('vendor-order-status',[ $order->order->order_number,  'processing']) }}" {{  $order->status == "processing" ? 'selected' : ''  }}>{{ __('Processing') }}</option>
                                            <option value="{{ route('vendor-order-status',[ $order->order->order_number,  'completed']) }}" {{  $order->status == "completed" ? 'selected' : ''  }}>{{ __('Completed') }}</option>
                                            <option value="{{ route('vendor-order-status',[ $order->order->order_number,  'declined']) }}" {{  $order->status == "declined" ? 'selected' : ''  }}>{{ __('Declined') }}</option>
                                            </select>

                                        </div>

                                        </td>

                                                  </tr>

                                                  @break
                    @endforeach

                                                  @endforeach
                                                  </tbody>

                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

{{-- ORDER MODAL --}}

<div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="submit-loader">
        <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
    </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{__('Update Status') }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">{{ __("You are about to update the Order's Status.") }}</p>
        <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- ORDER MODAL ENDS --}}


@endsection

@section('scripts')

{{-- DATA TABLE --}}

    <script type="text/javascript">


$('.vendor-btn').on('change',function(){
          $('#confirm-delete2').modal('show');
          $('#confirm-delete2').find('.btn-ok').attr('href', $(this).val());

});

        var table = $('#geniustable').DataTable({
               ordering: false
           });

    </script>

{{-- DATA TABLE --}}

@endsection
