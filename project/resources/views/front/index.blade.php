@extends('layouts.front')
@section('styles')
<style>
.lazy-x {
    -webkit-animation: sharp 5s; /* Chrome, Safari, Opera */
    animation: sharp 0.5s;
}

@-webkit-keyframes sharp {
    from {-webkit-filter: blur(5px);
  -moz-filter: blur(5px);
  -o-filter: blur(5px);
  -ms-filter: blur(5px);
  filter: blur(5px);}
    to {-webkit-filter: none;
  -moz-filter: none;
  -o-filter: none;
  -ms-filter: none;
  filter: none;}
}

@keyframes sharp {
     from {-webkit-filter: blur(5px);
  -moz-filter: blur(5px);
  -o-filter: blur(5px);
  -ms-filter: blur(5px);
  filter: blur(5px);}
    to {-webkit-filter: none;
  -moz-filter: none;
  -o-filter: none;
  -ms-filter: none;
  filter: none;}
}
</style>
@endsection
@section('content')

	

	@if($ps->slider == 1)
		<!-- Hero Area Start -->
		<section class="hero-area">

			@if($ps->slider == 1)

				@if(count($sliders))
				<div class="section-slideshow-v1 ">
					<div class="slick-side-h1">
					@foreach($sliders as $data)
						<div class="itemv-slide-h1">
							<div class=" info-sideh1">
								<div class="picture-slideshow">
								<div class="d-none d-md-block">
									<a href="">
									<img class="w-100" src="{{asset('assets/images/sliders/'.$data->photo)}}" class="img-fluid img_slideh1" alt="">
									</a>
								</div>
								<div class="d-block d-md-none">
									<a href="">
									<img class="w-100" src="{{asset('assets/images/sliders/'.$data->photo)}}" class="img-fluid img_slideh1" alt="">
									</a>
								</div>
								</div>
								<div class=" box-content-right">
								<div class=" text-right box-info box-info-1600053926591-0">
									<div class="box-title1 box-title1-1600053926591-0  animated">
									<h3 class="title-small mb-0" style="color:#000000;">{{$data->subtitle_text}}</h3>
									</div>
									<div class="box-title box-title-1600053926591-0 animated">
									<h3 class="titlebig mb-0" style="color:#010101;">{{$data->title_text}}</h3>
									</div>
									<div class="box-title2 box-title2-1600053926591-0  animated">
									<h3 class="title-small mb-0" style="color:#000000;">{{$data->details_text}}</h3>
									</div>
									<a class="button-main2 button-shop-1600053926591-0  animated" href="{{$data->link}}" style="color:#000000; border-color : #000000 "> Shop now </a>
								</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				
				@endif

			@endif
            <!-- <div class="hero-right-area">
                <a href="{{$ps->slider_right_banner_link}}" class="banner banner1">
                    <div class="img" style="background-image: url({{ $ps->slider_right_banner1 ? asset('assets/images/'.$ps->slider_right_banner1):asset('assets/images/noimage.png') }})"></div>

                </a>
                <a href="{{$ps->slider_right_banner_link1}}" class="banner banner2">
                    <div class="img" style="background-image: url({{ $ps->slider_right_banner2 ? asset('assets/images/'.$ps->slider_right_banner2):asset('assets/images/noimage.png') }})"></div>
                </a>
            </div> -->

		</section>
		<!-- Hero Area End -->
	@endif

	<div class="total-content" id="content">
  <!-----------------------------------category----------------------------------->
  <section class="category-div">
    <div class="container">
      <div class="main-heading text-center">
        <h2 class="title_heading">Shop By Category</h2>
        <div class="info-des mt-4">
            <p>Our Best Selling Premium Quality Products</p>
        </div>  
      </div>
      <div class="row">
        @foreach($categories as $category)
        <div class="col-sm-4 col-xs-cat">
          <div class="itemss-thumb">
              <img src="{{ asset('assets/images/categories/'.$category->photo) }}" class="img-fluid cate-img" alt="Image">
              <a href="{{ route('front.category',$category->slug) }}" class="over-layer-cat"></a>
          </div>
          <div class="cat-content">
            <h3>{{ $category->name }}</h3>
          </div>  
        </div>
        @endforeach
        </div>
      </div>
  </section>
<!-----------------------------------//category--------------------------------->  
  <section class="products-carousels">
              <div class="container-fluid">
                <div class="main-heading text-center">
                  <h2 class="title_heading">Featured Product</h2>
                  <div class="info-des mt-4">
                      <p>Our Best Selling Premium Quality Featured Products</p>
                  </div>  
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div id="" class="owl-carousel news-slider">
                    @foreach($feature_products as $prod)
                      <div class="post-slide">
                        <div class="post-img">
                          <img src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="">
                          <a href="{{ route('front.product', $prod->slug) }}" class="over-layer">
                            <!-- <i class="fa fa-link"></i> -->
                          </a>
                        </div>
                        <div class="post-content">
                          <h3 class="post-title">
                            <a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>
                          </h3>
                          <p class="p-des">{{ $prod->showDescription() }}</p>
                          <h6 class="category">{{ $prod->category->name }}</h6>
                          <div class="product_price">
                            <del>{{ $prod->showPreviousPrice() }}</del>
                            <span class="price">{{ $prod->showPrice() }}</span>
                        </div>
                        <div class="buttons-add">
                          @if(Auth::guard('web')->check())
                          <span class="add-to-wish addtowishlist btn" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title=" {{ __('Add To Wishlist') }}" data-placement="right">
                          <?php
                          $user = Auth::guard('web')->user();
                          $ck = App\Models\Wishlist::where('user_id','=',$user->id)->where('product_id','=',$prod->id)->get()->count();
                          ?>
                          @if($ck > 0)
                          <i class="fa fa-heart" aria-hidden="true"></i>
                          @else
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                          @endif
                          </span>
                          @else
                          <a href="javascript:void('0');" id="wish-btn" class="btn addtowishlist"><i class="fa fa-heart-o" aria-hidden="true"></i> <i class="fa fa-heart d-none" aria-hidden="true"></i></a>
                          @endif
                          <!-- <a href="#" class="btn addtocart">Add To Cart</a> -->
                          <span class="add-to-cart add-to-cart-btn" data-href="{{ route('product.cart.add',$prod->id) }}" data-cs_href="{{route('product.cross-sell',$prod->id)}}">
                            <i class="icofont-cart"></i> {{ __('Add To Cart') }}
                          </span>
                        </div>
                        </div>
                      </div>
                      @endforeach
                        
                      
                     
                    </div>
                  </div>
                </div>
              </div>  
             </section>
            <!------------------------------------------benifits------------------------------->
             <section class="benifits-tea paddings-top padding-bottom margins-both">
                <div class="container-fluid">
                    <div class="main-heading text-center">
                      <h2 class="title_heading">Benefits of green tea</h2>
                      <div class="info-des mt-4">
                          <p>Green tea is high in antioxidants that can improve the function of your body and brain.</p>
                      </div>  
                    </div>
                    <div class="row mini-content align-items-center">
                        <div class="col-sm-3 col-md-3">
                          <div class="list-info-item justify-content-end">
                            <div class="item content-info text-right">
                              <div class="mini-title">Strong Anti-Oxidant</div>
                              <div class="mini-des">Contains healthy bioactive compounds..</div>
                            </div>
                            <div class="item box-icon text-right">
                              <img src="{{asset('assets/front/images/info-icon1.webp')}}" alt="banner" class="img-fluid">
                            </div>
                          </div>
                          <div class="list-info-item justify-content-end">
                            <div class="item content-info text-right">
                              <div class="mini-title">Prevent Cancer</div>
                              <div class="mini-des">An important role in the prevention of cancer.</div>
                            </div>
                            <div class="item box-icon text-right">
                              <img src="{{asset('assets/front/images/info-icon2.webp')}}" alt="banner" class="img-fluid">
                            </div>
                          </div>
                          <div class="list-info-item justify-content-end">
                            <div class="item content-info text-right">
                              <div class="mini-title">Increases Heart Health</div>
                              <div class="mini-des">Green tea can increase fat burning and boost metabolic rate</div>
                            </div>
                            <div class="item box-icon text-right">
                              <img src="{{asset('assets/front/images/info-icon3.webp')}}" alt="banner" class="img-fluid">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6 pb-4 pb-lg-0 text-center">
                          <div class="box-imginfo">
                            <a href="" class="adv-thumb-link">
                              <img src="{{asset('assets/front/images/info-v1.webp')}}" class="img-fluid" alt="banner">
                            </a>
                          </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-12">
                          <div class="list-info-item justify-content-start">
                            <div class="item box-icon text-left">
                              <img class="img-fluid" src="{{asset('assets/front/images/info-icon6.webp')}}" alt="banner">
                            </div>
                            <div class="item content-info text-left">
                              <div class="mini-title">Help strengthen bones</div>
                              <div class="mini-des">Green tea also helps to keep your bones healthy and strong.</div>
                            </div>
                          </div>
                          <div class="list-info-item justify-content-start">
                            <div class="item box-icon text-left">
                              <img class="img-fluid" src="{{asset('assets/front/images/info-icon5.webp')}}" alt="banner">
                            </div>
                            <div class="item content-info text-left">
                              <div class="mini-title">Supports memory</div>
                              <div class="mini-des">It may also help boost brain function.</div>
                            </div>
                          </div>
                          <div class="list-info-item justify-content-start">
                            <div class="item box-icon text-left">
                              <img class="img-fluid" src="{{asset('assets/front/images/info-icon6.webp')}}" alt="banner">
                            </div>
                            <div class="item content-info text-left">
                              <div class="mini-title">Keep the youth</div>
                              <div class="mini-des">Prevent childhood related diseases.</div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
             </section>   
            <!---------------------------------------//benifits-------------------------------------->
            <!------------------------------------------product carousel----------------------------->
             <!------------------------------------------green tea carousel----------------------------->
             @foreach($categories as $category)
             <section class="products-carousels">
              <div class="container-fluid">
                <div class="main-heading text-center">
                  <h2 class="title_heading">{{$category->name}}</h2>
                  <div class="info-des mt-4">
                      <p>Our Best Selling Premium Quality {{$category->name}} Products</p>
                  </div>  
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="owl-carousel others-product">
                    @foreach($category->products()->whereStatus(1)->get() as $prod)
                      <div class="post-slide">
                        <div class="post-img">
                          <img src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="">
                          <a href="{{ route('front.product', $prod->slug) }}" class="over-layer">
                            <!-- <i class="fa fa-link"></i> -->
                          </a>
                        </div>
                        <div class="post-content">
                          <h3 class="post-title">
                            <a href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a>
                          </h3>
                          <p class="p-des">{{ $prod->showDescription() }}</p>
                          <h6 class="category">{{ $prod->category->name }}</h6>
                          <div class="product_price">
                            <del>{{ $prod->showPreviousPrice() }}</del>
                            <span class="price">{{ $prod->showPrice() }}</span>
                        </div>
                        <div class="buttons-add">
                          @if(Auth::guard('web')->check())
                          <span class="add-to-wish addtowishlist btn" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title=" {{ __('Add To Wishlist') }}" data-placement="right">
                          <?php
                          $user = Auth::guard('web')->user();
                          $ck = App\Models\Wishlist::where('user_id','=',$user->id)->where('product_id','=',$prod->id)->get()->count();
                          ?>
                          @if($ck > 0)
                          <i class="fa fa-heart" aria-hidden="true"></i>
                          @else
                          <i class="fa fa-heart-o" aria-hidden="true"></i>
                          @endif
                          </span>
                          @else
                          <a href="javascript:void('0');" id="wish-btn" class="btn addtowishlist"><i class="fa fa-heart-o" aria-hidden="true"></i> <i class="fa fa-heart d-none" aria-hidden="true"></i></a>
                          @endif
                          <!-- <a href="{{ route('product.cart.add',$prod->id) }}" class="btn addtocart">Add To Cart</a> -->
                          <span class="add-to-cart add-to-cart-btn" data-href="{{ route('product.cart.add',$prod->id) }}" data-cs_href="{{route('product.cross-sell',$prod->id)}}">
                            <i class="icofont-cart"></i> {{ __('Add To Cart') }}
                          </span>
                        </div>
                        </div>
                      </div>
                      @endforeach  
                      
                      
                    </div>
                  </div>
                </div>
              </div>  
            </section>
            <!------------------------------------------//green tea carousel----------------------------->
            <div class="container"><hr></div> 
            <!-----------------------------------------//product carousel---------------------------->
            @endforeach
            <!---------------------------------------collection-------------------------------------->
            <section class="section-banner-v5 mt-all mb-all">
              <div class="container-fluid">
                <div class="row banner_box align-items-center">
                  <div class=" col-lg-6 text-md-right text-center order-1 order-md-1 ">
                    <div class="banner-left">
                      <h6 class="title">BENEFITS OF TEA</h6>
                      <div class="desc">Numerous studies have shown that a variety of teas may boost your immune system, fight off inflammation, and even ward off cancer and heart disease. While some brews provide more health advantages than others, there's plenty of evidence that regularly drinking tea can have a lasting impact on your wellness.</div>
                      <a class="button button-1599807834220-0" href="/custom-tea" style="border: 1px solid ;">
                        <span>SHOP NOW</span>
                      </a>
                    </div>
                  </div>
                  <div class="col-lg-6 order-2 order-md-2 ">
                    <div class="picture-banner">
                      <a href="#">
                        <img src="{{asset('assets/front/images/banner-v5-1.webp')}}" class="img-fluid" alt="">
                      </a>
                    </div>
                  </div>      
                </div>
              </div>
            </section> 
            <!---------------------------------------//collection----------------------------------->
            
            <!-------------------------------------------video-------------------------------------->
            <div class="section-video-v1 mt-all mbt-all" style="background-image: url(assets/front/images/bg-video.jpg)">
              <div class="container text-center">
                <p class="sub-titl relative e mb-0">Daily Essentials</p>
                <h3 class="title relative  mb-0">Green tea is a great choice for clearing dark spots and improving your skin's complexion</h3>
                <div class="row justify-content-center">
                  <div class="col-lg-9">
                    <div class="box-images mt-2">
                      <a data-fancybox="" href="{{asset('assets/images/video.mp4')}}">
                        <div class="box-video relative">
                          <img src="assets/front/images/video-v1.webp" class="img-fluid w-100" alt="Image">
                          <span class="absolute play-buttons-icon">
                           <i class="icofont-play-alt-2"></i>
                          </span>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-------------------------------------------//video-------------------------------------->
            <!---------------------------------------collection-------------------------------------->
            <section class="section-banner-v5 mt-all mb-all">
              <div class="container-fluid">
                <div class="row banner_box align-items-center">
                  <div class=" col-lg-6 text-md-left text-center order-1 order-md-2  ">
                    <div class="banner-left">
                      <h6 class="title">BLACK TEA</h6>
                      <div class="desc">Black tea is rich in antioxidants that may provide benefits including improved heart and gut health, lowered “bad” LDL cholesterol, blood pressure, and blood sugar levels. Aside from water, black tea is one of the most consumed beverages in the world.</div>
                      <a class="button button-1599789442999-0" href="/category/tea-leaf" style="border:1px solid ;">
                        <span>SHOP NOW</span>
                      </a>
                    </div>
                   </div> 
                   <div class="col-lg-6 order-2 order-md-1 ">
                    <div class="picture-banner">
                      <a href="#">
                        <img src="{{asset('assets/front/images/banner-v5-2.webp')}}" class="img-fluid" alt="">
                      </a>
                    </div>
                  </div>   
                </div>
              </div>
            </section> 
            <!---------------------------------------//collection----------------------------------->
            <!------------------------------------------image banner----------------------------------->  
            <section class="banner-section">
              <div class="container-fluid">
                        <div class="row">
                        <div class="col-lg-12 remove-padding">
                        <div class="img">
                          <a class="banner-effect" href="{{$ps->gallery_large_banner_link}}">
                            <img src="{{ $ps->gallery_large_banner ? asset('assets/images/'.$ps->gallery_large_banner):asset('assets/images/noimage.png') }}" class="img-fluid" alt="">
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
            </section>
            <!----------------------------------------//image banner----------------------------------->
            <!-------------------------------------------- testimonials ---------------------------->
            <section class="testimonials-carousels">
              <div class="container-fluid">
                <div class="main-heading text-center">
                  <h2 class="title_heading">More Love For Ashta Tea</h2>
                  <div class="info-des mt-4">
                      <p>Checkout some unbiased reviews from our users</p>
                  </div>  
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="owl-carousel testimonial">
                      <div class="testimonial-slide">
                        <div class="testimonial-img">
                          <img src="assets/front/images/testimonial.png" class="img-fluid" alt="">
                        </div>
                      </div>
                      <div class="testimonial-slide">
                        <div class="testimonial-img">
                          <img src="assets/front/images/testimonial-2.png" class="img-fluid" alt="">
                        </div>
                      </div>
                      <div class="testimonial-slide">
                        <div class="testimonial-img">
                          <img src="assets/front/images/testimonial-3.png" class="img-fluid" alt="">
                        </div>
                      </div>
                      <div class="testimonial-slide">
                        <div class="testimonial-img">
                          <img src="assets/front/images/testimonial.png" class="img-fluid" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
            </section>
            <!-------------------------------------------// testimonials -------------------------->
            <!------------------------------------------custom tea----------------------------------->
            <section class="custon-tea paddings-top padding-bottom margins-both">
                <div class="container">
                  <div class="banner-box">
                    <div class="banner-info text-center">
                      <div class="box-bg">
                        <div class="box-border">
                          <div class="subtitle">
                            <span>Where can I get some</span>
                          </div>
                          <h3 class="title">Collection New</h3>
                          <a href="/category" class="btn button-shop text-center">SHOP NOW</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            <!------------------------------------------custom tea----------------------------------->

            <!-- desktop pre footer -->
            <section class="feature-section">
              <div class="container-fluid">
                <div class="row">
                @foreach($services->chunk(4) as $chunk)
                @foreach($chunk as $service)
                  <div class="col-sm-3 col-mob-xs">
                    <div class="info-box-wrapper">
                      <div class="box-icon-wrapper">
                        <div class="info-box-icon">
                          <img src="{{ asset('assets/images/services/'.$service->photo) }}" alt="" class="img-fluid">
                        </div>
                      </div>
                      <div class="info-box-content">
                        <h4 class="info-box-title">{{ $service->title }}</h4>	
                        <div class="info-box-inner">
                          <p>{!! $service->details !!}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endforeach  
                </div>
              </div>
			      </section>

            <!-- mobile pre footer -->
            <section class="mobile-feature-section">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="feature-inner-mob">
                    @foreach($services->chunk(4) as $chunk)
                      @foreach($chunk as $service)
                        <div class="mob-info-boxs">
                          <div class="mob-info-img">
                            <img src="{{ asset('assets/images/services/'.$service->photo) }}" alt="" class="img-fluid">
                          </div>
                          <div class="mob-info-text">
                            <h6>{{ $service->title }}</h6>
                            <p>{!! $service->details !!}</p>
                          </div>
                        </div>
                      @endforeach
                    @endforeach 
                    </div>
                  </div>
                </div>
              </div>
            </section>

            </div>
	

   




@endsection


@section('scripts')
	<script>
		let checkTrur = 0;
		$(window).on( 'scroll', function(){
			
		if(checkTrur == 0){
			$('#extraData').load('{{route('front.extraIndex')}}');
			checkTrur = 1;
		}
		});

	</script>
@endsection
