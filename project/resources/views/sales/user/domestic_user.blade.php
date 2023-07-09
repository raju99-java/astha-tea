@extends('layouts.sales') 

@section('content')  
					<input type="hidden" id="headerdata" value="{{ __('CUSTOMER') }}">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __("Domestic Customers") }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('sales.dashboard') }}">{{ __("Dashboard") }} </a>
											</li>
											<li>
												<a href="{{ route('sales-domestic-user') }}">{{ __("Domestic Customers") }}</a>
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
										<div class="table-responsiv">
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th>{{ __("Name") }}</th>
									                        <th>{{ __("Email") }}</th>
															<th>{{ __("Phone") }}</th>
									                        <th>{{ __("Options") }}</th>
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
               ajax: '{{ route('sales-user-datatables','domestic') }}',
               columns: [
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
						{ data: 'phone', name: 'phone' },
            			{ data: 'action', searchable: false, orderable: false }
                     ],
               language : {
                	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
                },
                drawCallback : function( settings ) {
                        $('.select').niceSelect();  
                }
            });
			$(function() {
        $(".btn-area").append('<div class="col-sm-4 table-contents">'+
        	'<a class="add-btn" href="{{route('sales-user-create')}}">'+
          '<i class="fas fa-plus"></i> <span class="remove-mobile">{{ __("Add New") }}<span>'+
          '</a>'+
          '</div>');
      });

		

		
																
    </script>

{{-- DATA TABLE --}}
    
@endsection   