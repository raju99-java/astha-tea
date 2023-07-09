@extends('layouts.front')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/front/css/user.css')}}">
	<link rel="stylesheet" href="{{asset('assets/front/css/datatables.css')}}">
@endsection
@section('content')


<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
					<div class="user-profile-details">
						<div class="order-history">
							<div class="header-area">
								<h4 class="title">
									{{ __('Custom Tea Purchased Items') }}
								</h4>
							</div>
							<div class="mr-table allproduct mt-4">
								@include('includes.form-success')
									<div class="table-responsiv">
											<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>{{ __('#Order') }}</th>
														<th>{{ __('Review') }}</th>
														<th>{{ __('Order Total') }}</th>
														<th>{{ __('Date') }}</th>
														<th>{{ __('Order Status') }}</th>
														<th>{{ __('Action') }}</th>


													</tr>
												</thead>
												<tbody>
													 @foreach($orders as $order)
													<tr>
														<td>
																{{$order->order_number}}
														</td>
														<td>
															@if($order->status!='completed')
															@if($order->rating=='0')
															<a data-href="{{route('user-customtea-review',$order->id)}}" class="review-edit" data-toggle="modal" data-target="#modal1">  Review Order</a>
															@else
															<p class="review-given">Review Given</p>
															@endif
															@else
															<p>Waiting for order conformation</p>
															@endif
														</td>
														<td>
																{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
														</td>
														<td>
																{{date('d M Y',strtotime($order->created_at))}}
														</td>
														<td>
															<div class="order-status {{ $order->status }}">
																	{{ucwords($order->status)}}
															</div>
														</td>
														<td>
															<a class="mybtn1 sm sm1" href="{{route('user-customtea-order',$order->id)}}">
																	{{ __('VIEW ORDER') }}
															</a>
														</td>

													</tr>
													@endforeach
												</tbody>
											</table>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	{{-- ADD / EDIT MODAL --}}

	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
							
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<!-- <div class="submit-loader">
					<img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
				</div> -->
				<div class="modal-header">
					<h5 class="modal-title review-titles"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

				</div>
				<!-- <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
				</div> -->
			</div>
		</div>
	</div>

{{-- ADD / EDIT MODAL ENDS --}}
@endsection
@section('scripts')
<script src="{{asset('assets/front/js/datatables.js')}}"></script>
<script>
	$(document).on('click','.review-edit',function(){
	// if(admin_loader == 1)
	// {
	// $('.submit-loader').show();
	// }
  $('#modal1').find('.modal-title').html('Review Order');
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      
    });
});

</script>
@endsection