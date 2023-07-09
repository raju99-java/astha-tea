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
				<h4 class="heading">{{ __('Sales Person') }} 
				</h4>
				<ul class="links">
					<li>
						<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
					</li>
					<li>
						<a href="javascript:;">{{ __('Sales Person') }} </a>
					</li>
					<li>
						<a href="{{ route('admin-salesperson-create') }}">{{ __('Sales Person') }}</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>

	<form id="geniusform" action="{{route('admin-salesperson-store')}}" method="POST" enctype="multipart/form-data">
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
										<div class="col-lg-4">
										<div class="left-area">
											<h4 class="heading">{{ __("Sales Person Profile Image") }} *</h4>
										</div>
										</div>
										<div class="col-lg-7">
										<div class="img-upload">
											<div id="image-preview" class="img-preview" style="background: url({{ asset('assets/images/noimage.png') }});">
												<label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __("Upload Image") }}</label>
												<input type="file" name="photo" class="img-upload" id="image-upload">
											</div>
											<p class="text">{{ __("Prefered Size: (600x600) or Square Sized Image") }}</p>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Full Name') }}* </h4>
												<p class="sub-heading">{{ __('(In Any Language)') }}</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="{{ __('Enter Full Name') }}"
												name="name">
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Email') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="email" type="email" class="input-field"
												placeholder="{{ __('Enter Email') }}">
											
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Phone Number') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="phone" type="tel" class="input-field"
												placeholder="{{ __('Enter Phone Number') }}">
											
										</div>
									</div>
									<div class="row">
										<div class="col-lg-4">
										<div class="left-area">
											<h4 class="heading">{{ __("GOVT. Id Proof") }} *</h4>
										</div>
										</div>
										<div class="col-lg-7">
										<div class="img-upload">
											<div id="image-preview" class="img-preview" style="background: url({{ asset('assets/images/noimage.png') }});">
												<label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __("Upload Image") }}</label>
												<input type="file" name="govt_id_proof" class="img-upload" id="govt-id-proof-upload">
											</div>
											<p class="text">{{ __("Prefered Size: (600x600) or Square Sized Image") }}</p>
										</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													{{ __('Address') }} *
												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="text-editor">
												<textarea name="address" class="input-field"
													placeholder="{{ __('Enter Address') }}"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">{{ __('Password') }}*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="password" type="password" class="input-field"
												placeholder="{{ __('Enter Password') }}">
											
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
												type="submit">{{ __('Add') }}</button>
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