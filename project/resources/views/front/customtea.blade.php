@extends('layouts.front')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/front/css/custom-tea.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('assets/front/css/product_details.css')}}"> -->
@endsection
@section('content')

<section class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="breadcrumb-title-div">
          <div class="bread-left-side">
            <h2>CUSTOM TEA</h2>
          </div>
          <div class="breadcrumb-ul right-side">
            <ul>
              <li>
                <a href="{{route('front.index')}}">HOME</a>/
              </li>
               <li>
                  <a href="{{route('front.customtea')}}">{{__('CUSTOM TEA') }}</a>
               </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Breadcrumb Area Start -->

<!-- Breadcrumb Area End -->
<div class="total-content" id="content">
  <section class="custom-tea-section">
      <div class="container">
      @include('includes.form-success')
      <form class="custom-tea-form" action="{{route('customtea-submit')}}" method="POST" id="customteaform">
        {{ csrf_field() }}
        
            <div class="total-custom-tea-div"> 
              <div class="row">
                  <div class="col-sm-4 col-md-4">
                      <div class="color-div text-center">
                          <h3>Choose Your Smell Component(Leaf)</h3>
                          <select  class="form-control selected-tea" name="smell" onchange="calculateTotal();" id="smell">
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
                          <select  class="form-control selected-tea" name="color" id="color" onchange="calculateTotal();">
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
                          <select id="weight" class="form-control selected-tea" name="weight" onchange="calculateTotal();">
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
                      <div class="social-links social-sharing a2a_kit a2a_kit_size_32">
                      <ul class="link-list social-links">
                        <li>
                          <a class="facebook a2a_button_facebook" href="">
                            <i class="fab fa-facebook-f"></i>
                          </a>
                        </li>
                        <li>
                          <a class="twitter a2a_button_twitter" href="">
                            <i class="fab fa-twitter"></i>
                          </a>
                        </li>
                        <li>
                          <a class="linkedin a2a_button_linkedin" href="">
                            <i class="fab fa-linkedin-in"></i>
                          </a>
                        </li>
                        <li>
                          <a class="whatsapp a2a_button_whatsapp" href="">
                            <i class="fab fa-whatsapp"></i>
                          </a>
                        </li>
                        <li>
                          <a class="pinterest a2a_button_pinterest" href="">
                            <i class="fab fa-pinterest-p"></i>
                          </a>
                        </li>
                        <li>
                          <a class="email a2a_button_email" href="">
                            <i class="fa fa-envelope"></i>
                          </a>
                        </li>
                        <li>
                          <a class="sms a2a_button_sms" href="">
                            <i class="fa fa-comments"></i>
                          </a>
                        </li>
                      </ul>
                      <script async src="https://static.addtoany.com/menu/page.js"></script>  
                      </div>

                    <div class="wd-after-add-to-cart">
									    <div class="pbottom-paymnt-icon">
                      <h4>Guaranteed safe checkout</h4>
                      <img class="payment-method" src="{{asset('assets/front/images/product-payment.png')}}">
                    </div>
                  
                    <div class="total-pricess">
                      <span class="total-span">Total Price: <span id="total-price">0</span> INR</span>
                    </div>
                </div>
                </div>
              </div>
              </div>
             
              <!-- <div class="row">
                  <div class="col-sm-12">
                    <div class="add-more-content">
                    <div class="social-links social-sharing a2a_kit a2a_kit_size_32">
                    <ul class="link-list social-links">
                      <li>
                        <a class="facebook a2a_button_facebook" href="">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                      </li>
                      <li>
                        <a class="twitter a2a_button_twitter" href="">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </li>
                      <li>
                        <a class="linkedin a2a_button_linkedin" href="">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                      </li>
                      <li>
                        <a class="whatsapp a2a_button_whatsapp" href="">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      </li>
                      <li>
                        <a class="pinterest a2a_button_pinterest" href="">
                          <i class="fab fa-pinterest-p"></i>
                        </a>
                      </li>
                      <li>
                        <a class="email a2a_button_email" href="">
                          <i class="fa fa-envelope"></i>
                        </a>
                      </li>
                      <li>
                        <a class="sms a2a_button_sms" href="">
                          <i class="fa fa-comments"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <script async src="https://static.addtoany.com/menu/page.js"></script>

                  <div class="wd-after-add-to-cart">
									<div class="pbottom-paymnt-icon">
                    <h4>Guaranteed safe checkout</h4>
                    <img class="payment-method" src="{{asset('assets/front/images/product-payment.png')}}">
                  </div>
                  
                  <div class="total-pricess">
                    <span class="total-span">Total Price: <span id="total-price">0</span> INR</span>
                  </div>
                </div> -->


                    </div>
                    @include('includes.admin.form-login')
                      <div class="buy-now-button text-center">
                         @if(Auth::guard('web')->check())
                         <input class="btn btn-lg" id="buy-now" type="submit" value="Buy Now">
                          @else
                          <a href="javascript:void('0');" class="btn btn-lg notlogin" id="buy-now"> Buy Now</a>
                          @endif
                      </div>
                      
                  </div>
              </div>
          </div>  
      </form>
      </div>
  </section>
</div>







@endsection
@section('scripts')
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
@endsection