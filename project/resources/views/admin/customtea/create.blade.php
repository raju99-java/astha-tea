@extends('layouts.admin')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet" />

@endsection
@section('content')

<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Custom Tea') }} 
				</h4>
				<ul class="links">
					<li>
						<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
					</li>
					<li>
						<a href="javascript:;">{{ __('Custom Tea') }} </a>
					</li>
					<li>
						<a href="{{ route('admin-prod-customtea-create') }}">{{ __('Add Custom Tea Product') }}</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>

	<form id="geniusform" action="{{route('admin-prod-customtea-store')}}" method="POST" enctype="multipart/form-data">
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
		
									@include('includes.admin.form-both')
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Product Name') }}* </h4>
												<p class="sub-heading">{{ __('(In Any Language)') }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="{{ __('Enter Product Name') }}"
												name="name" required="">
										</div>
									</div>
		
									
		
									
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Type') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select id="type" name="type" required="">
												<option value="">{{ __('Select Type') }}</option>
												<option value="1">{{ __('Smell') }}</option>
												<option value="2">{{ __('Colour') }}</option>
												
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Product Price') }}*</h4>
												<p class="sub-heading">{{ __('(Per Gram Price)') }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="price" type="text" class="input-field"
												placeholder="{{ __('e.g 2000') }}">
											
										</div>
									</div>
									<div class="row" id="stckprod">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Product Stock') }}*</h4>
												<p class="sub-heading">{{ __('(Write on Grams)') }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="stock" type="text" class="input-field"
												placeholder="{{ __('e.g 2000') }}">
											
										</div>
									</div>
		
									<!-- <div class="row">
										<div class="col-lg-12">
											<div class="checkbox-wrapper">
												<input type="checkbox" name="seo_check" value="1" class="checkclick"
													id="allowProductSEO" value="1">
												<label for="allowProductSEO">{{ __('Allow Product SEO') }}</label>
											</div>
										</div>
									</div>
		
		
		
									<div class="showbox">
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">{{ __('Meta Tags') }} *</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<ul id="metatags" class="myTags">
												</ul>
											</div>
										</div>
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">
														{{ __('Meta Description') }} *
													</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="text-editor">
													<textarea name="meta_description" class="input-field"
														placeholder="{{ __('Meta Description') }}"></textarea>
												</div>
											</div>
										</div>
									</div> -->
		

		
		
									<div class="row">
										<div class="col-lg-12 text-center">
											<button class="addProductSubmit-btn"
												type="submit">{{ __('Create Product') }}</button>
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
	$('.cropme').simpleCropper();
</script>



<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection