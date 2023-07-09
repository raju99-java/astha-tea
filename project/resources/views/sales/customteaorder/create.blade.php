@extends('layouts.sales')
@section('styles')

<link rel="stylesheet" href="{{asset('assets/front/css/custom-tea.css')}}">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Upright:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/front/css/toastr.css')}}">
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
.color-div h3 {
    font-size: 19px;
    font-weight: 800;
    padding-bottom: 5px;
    font-family: 'Cormorant Upright';
    color: #4c9a2a;
    text-align: center;
}
.custom-tea-content {
    min-height: 155px !important;
}
.total-pricess {
    margin-top: 55px !important;
}
.custom-ranging {
    min-height: 155px !important;
    padding: 1px 15px 12px !important;
}
.add-product-content .product-description .body-area{
    padding: 30px 15px 30px 15px !important;
}
.total-custom-tea-div {
    padding: 15px 5px 15px 5px !important;
    box-shadow: none !important;
}
.custom-tea-btn{
	background-color: #4c9a2a !important;
    border-radius: 0 !important;
    color: #fff !important;
    border: none !important;
    padding: 20px 200px !important;
    font-size: 16px !important;
    font-weight: 600 !important;
    margin-top: 21px !important;
    text-transform: uppercase !important;
    width: fit-content !important;
    height: auto !important;
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
	.custom-tea-btn{
		width: 100% !important;
    	padding: 20px 10px !important;
		margin-top: 0px !important;
	}
	.total-custom-tea-div {
		padding: 15px 5px 0px 5px !important;
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
						<a href="javascript:;">{{ __('Custom Tea Orders') }} </a>
					</li>
					<li>
						<a href="{{ route('sales-customtea-order-create') }}">{{ __('Create New') }}</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>

	<form id="salescartform" action="{{route('sales-customtea-order-store')}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}	
	<div class="row">
		<div class="col-lg-12">
			<div class="add-product-content">
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
											<select name="user" required="" class="select2 bold" id="user">
												<option value="">Select User</option>
												@foreach($users as $user)
												<option value="{{$user->id}}">{{$user->name}} ({{$user->phone}})</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="total-custom-tea-div"> 
										<div class="row">
											<div class="col-sm-4 col-md-4">
												<div class="color-div text-center">
													<h3>Choose Your Smell Component(Leaf)</h3>
													<select  class="form-control selected-tea" name="smell" onchange="calculateTotal();" id="smell" required="">
														<option value="">Select Your Smell Component</option>
														@foreach($smell as $sm)
														<option value="{{$sm->id}}">{{$sm->name}} ({{$sm->price * 1000}} Rs/KG)</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-sm-4 col-md-4">
												<div class="color-div text-center">
													<h3>Choose Your Colour Component(CTC)</h3>
													<select  class="form-control selected-tea" name="color" id="color" onchange="calculateTotal();" required="">
														<option value="" >Select Your Colour Component</option>
														@foreach($color as $cl)
														<option value="{{$cl->id}}">{{$cl->name}} ({{$cl->price * 1000}} Rs/KG)</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-sm-4 col-md-4">
												<div class="color-div text-center">
													<h3>Choose Your Tea Weight</h3>
													<select id="weight" class="form-control selected-tea" name="weight" onchange="calculateTotal();" required="">
														<option value="" >Select Your Tea Weight</option>
														<option value="50">50 gm</option>
														<option value="100">100 gm</option>
														<option value="250">250 gm</option>
														<option value="500">500 gm</option>
														<option value="750">750 gm</option>
														<option value="1000">1 KG</option>
														<option value="2000">2 KG</option>
														<option value="5000">5 KG</option>
														<option value="10000">10 KG</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row mt-4">
											

											<div class="col-sm-4 col-md-4">
												<div class="custom-ranging">
												<h4>Smell Component Percentage</h4> 
												<div style="max-width: 400px; margin: 0 auto;" class="range-slider">
													<input class="range-slider__range" type="range" value="50" min="1" max="99" step="1" id="changesmell" name="smell_per">
													<div style="margin: 2px 0px; text-align: center; float: left; color: #fff;">1</div>
													<div style="float: right; text-align: center; margin: 2px 0px; color: #fff;">99</div>
													<div class="range-slider__value">50%</div>
												</div>   
												</div>
											</div>
											<div class="col-sm-4 col-md-4">
												<div class="custom-ranging">
													<h4>Colour Component Percentage</h4>
													<div style="max-width: 400px; margin: 0 auto;" class="range-slider">
													<input class="range-slider__range_two" type="range" value="50" min="1" max="99" step="1" id="changecolor" name="color_per">
													<div style="margin: 2px 0px; text-align: center; float: left; color: #fff;">1</div>
													<div style="float: right; text-align: center; margin: 2px 0px; color: #fff;">99</div>
													<div class="range-slider__value_two">50%</div>
													</div> 
												</div>
											</div>

											<div class="col-sm-4 col-md-4">
												<div class="custom-tea-content">
													<div class="wd-after-add-to-cart">
														
												
														<div class="total-pricess">
														<span class="total-span">Total Price: <span id="total-price">0</span> INR</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 text-center">
											<button class="addProductSubmit-btn custom-tea-btn"
												type="submit">{{ __('Submit') }}</button>
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

<script src="{{asset('assets/front/js/toastr.js')}}"></script>

<script type="text/javascript">
	$(function () {
		$('.select2').select2();
	});
</script>
<script>
      var rangeSlider = function(){
  var slider = $('.range-slider'),
      range = $('.range-slider__range'),
      value = $('.range-slider__value');
    
  slider.each(function(){

    value.each(function(){
      var value = $(this).prev().attr('value');
      $(this).html(value);
    });
    range.on('input', function(){
      $(value).html(this.value + '%');
      
      
    });
  });
};

rangeSlider();
    </script>


<script>
  var rangeSlider = function(){
  var slider = $('.range-slider'),
  range = $('.range-slider__range_two'),
  value = $('.range-slider__value_two');

slider.each(function(){

value.each(function(){
  var value = $(this).prev().attr('value');
  $(this).html(value);
});
range.on('input', function(){
  $(value).html(this.value + '%');
  
  
});
});
};

rangeSlider();
</script>
<script>
  var smell='';
  var color='';
  var weight='';

  $('#changecolor').on('change',function(){
  var val = $(this).val();
  var nextval= 100 - val;
  $('#changesmell').val(nextval);
  $('.range-slider__value').html(nextval+'%');
  calculateTotal();
  // alert(nextval);
});

$('#changesmell').on('change',function(){
  var vals = $(this).val();
  var nextvals= 100 - vals;
  $('#changecolor').val(nextvals);
  $('.range-slider__value_two').html(nextvals+'%');
  calculateTotal();
  // alert(val);
});


function calculateTotal(){
  smell=$('#smell').val();
  color=$('#color').val();
  weight=$('#weight').val();
  var smellval=$('#changesmell').val();
  var colorval=$('#changecolor').val();
  if(smell != '' && color != '' && weight != ''){
    $.ajax({
		type: "GET",
		url:mainurl+"/totalpricecheck",
		data:{smell:smell, color:color,weight:weight, smellval:smellval, colorval:colorval},
		success:function(data){
			

			$('#total-price').html(data);
			
			toastr.success('Total Price Updated');
		}
	});
  }
}
</script>
<script>
	$('#user').on('change',function(){
// $(document).on("change", "#user" , function(){
        var user_id = $(this).val();
		// alert(user_id);
            $.ajax({
                    type: "GET",
                    url:mainurl+"/sales/usercustomteacheck",
                    data:{user_id:user_id},
                    success:function(data){
                      
                      if(data.status=='1'){
						$('#changesmell').val(data.smell_per);
  						$('.range-slider__value').html(data.smell_per+'%');
						$('#changecolor').val(data.color_per);
  						$('.range-slider__value_two').html(data.color_per+'%');
						
						$('#smell').val(data.smell).change();
						$('#color').val(data.color).change();
						$('#weight').val(data.weight).change();
						
                        
                      }else{
                        // alert(0);
						toastr.error('User Not Having A Custom Tea Composition');
                      }
                      // toastr.success(langg.color_change);
                    }
              });
       });
</script>


<script src="{{asset('assets/admin/js/product.js')}}"></script>
@endsection