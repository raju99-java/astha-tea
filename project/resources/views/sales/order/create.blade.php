@extends('layouts.sales')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet" />
<style>
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 32px !important;
}
.remove {
    font-size: 13px !important;
}
.btn-primary {
    font-size: 14px !important;
}
.select2-container {
    display: initial !important;
    vertical-align: sub !important;
}
@media only screen and (max-width: 767px) {
	.mob-gap {
    	margin-bottom: 10px;
	}
	.remove {
    	margin-left: 16px !important;
		margin-right: 16px !important;
		width: 100% !important;
    	padding: 6px 10px !important;
	}
}
</style>
@endsection
@section('content')

<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Order') }} 
				</h4>
				<ul class="links">
					<li>
						<a href="{{ route('sales.dashboard') }}">{{ __('Dashboard') }} </a>
					</li>
					<li>
						<a href="javascript:;">{{ __('Orders') }} </a>
					</li>
					<li>
						<a href="{{ route('sales-order-create') }}">{{ __('Create New') }}</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>

	<form id="salescartform" action="{{route('sales-order-store')}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}	
	<div class="row">
		<div class="col-lg-10">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">
		
								<div class="gocover"
									style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
								</div>
		
									@include('includes.sales.form-both')
									
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('User') }}* </h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select name="user" required="" class="select2 bold">
												<option value="">Select User</option>
												@foreach($users as $user)
												<option value="{{$user->id}}">{{$user->name}} ({{$user->phone}})</option>
												@endforeach
											</select>
										</div>
									</div>
									<div id="option-wrapper">
										<div class="row" >
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ __('Product') }}* </h4>
												</div>
											</div>
											<div class="col-lg-10 mob-gap">
												<select name="product[]" required="" class="select2 bold">
													<option value="">Select Product</option>
													@foreach($prod as $pd)
													<option value="{{$pd->id}}">{{$pd->name}} (Stock: {{isset($pd->stock)?$pd->stock:0}})</option>
													@endforeach
												</select>
											</div>
											<!-- <div class="col-lg-5 mob-gap">
												<select name="qty[]" required="" class="select2 bold">
													<option value="">Select Quantity</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div> -->
											<div class="col-md-2">
												<a href="javascript:void('0');" id="add-option-form" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Add</a>
											</div>
										</div>
									</div>
									
									<!-- <div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Full Name') }}* </h4>
												<p class="sub-heading">{{ __('(In Any Language)') }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="{{ __('Enter Full Name') }}" name="name">
										</div>
									</div> -->
									
		

		
		
									<div class="row">
										<div class="col-lg-12 text-center">
											<button class="addProductSubmit-btn"
												type="submit">{{ __('Submit') }}</button>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	</form>
	
</div>



@endsection

@section('scripts')

<script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>



<script type="text/javascript">
	$(function () {
		$('.select2').select2();
	});
</script>
<script>

	var option_wrapper = $("#option-wrapper");
	var addOptionForm = $("#add-option-form");
	var index = 0;


	var getForm = function(index, action) {
		
		return $("<div class='row'><div class='col-lg-10 mob-gap'><select name='product[]' required='' class='select2 bold'><option value=''>Select Product</option> @foreach($prod as $pd) <option value='{{$pd->id}}'>{{$pd->name}} (Stock: {{isset($pd->stock)?$pd->stock:0}})</option> @endforeach </select></div><a href='javascript:void('0');' class='remove btn btn-danger'><i class='fa fa-times'></i> Remove Field</a></div>");
	};

	addOptionForm.on("click", function() {
		var form = getForm(++index);
		form.find(".remove").on("click", function() {
			$(this).parent().remove();
		});
		option_wrapper.append(form);
		$('.select2').select2();
	});

</script>



<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection