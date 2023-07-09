@extends('layouts.front')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/front/css/product_details.css')}}">
@endsection
@section('content')
@php
    // dd(Session::get('cart'));
@endphp
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-title-div">
                    <div class="bread-left-side">
                        <h2>{{ $productt->name }}</h2>
                    </div>
                    <div class="breadcrumb-ul right-side">
                        <ul>
                        <li><a href="{{ route('front.index') }}">HOME</a>/</li>
                        <li><a href="{{route('front.category',$productt->category->slug)}}">{{$productt->category->name}}</a>/</li>
                          @if($productt->subcategory_id != null)
                          <li><a
                              href="{{ route('front.subcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug]) }}">{{$productt->subcategory->name}}</a>/
                          </li>
                          @endif
                          @if($productt->childcategory_id != null)
                          <li><a
                              href="{{ route('front.childcat',['slug1' => $productt->category->slug, 'slug2' => $productt->subcategory->slug, 'slug3' => $productt->childcategory->slug]) }}">{{$productt->childcategory->name}}</a>/
                          </li>
                          @endif
                          <li><a href="{{ route('front.product', $productt->slug) }}">{{ $productt->name }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@php
// dd($productt->cross_selling_products);
$crossIds = [];
foreach ($productt->cross_selling_products as $crProd) {
  $crossIds[] = $crProd->cross_selling_product_id;
}

$countCsProds = 0;
$term = Illuminate\Support\Str::slug($productt->name, ' ');

// check if the product's childcategory is in `cs_category_relations` table
if (!empty($productt->childcategory->category_relation)) {

  $sType = $productt->childcategory->category_relation->search_type;

  // if related with 'category' then show products under that category
  if ($productt->childcategory->category_relation->cs_category_type == 'App\Models\Category') {
    $countCsProds = \App\Models\Product::where('category_id', $productt->childcategory->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();

  }
  // if related with 'subcategory' then show products under that subcategory
  elseif ($productt->childcategory->category_relation->cs_category_type == 'App\Models\Subcategory') {
    $countCsProds = \App\Models\Product::where('subcategory_id', $productt->childcategory->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
  // if related with 'childcategory' then show products under that childcategory
  elseif ($productt->childcategory->category_relation->cs_category_type == 'App\Models\Childcategory') {
    $countCsProds = \App\Models\Product::where('childcategory_id', $productt->childcategory->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
}

// check if the product's subcategory is in `cs_category_relations` table
elseif (!empty($productt->subcategory->category_relation)) {

  $sType = $productt->subcategory->category_relation->search_type;

  // if related with 'category' then show products under that category
  if ($productt->subcategory->category_relation->cs_category_type == 'App\Models\Category') {
    $countCsProds = \App\Models\Product::where('category_id', $productt->subcategory->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
  // if related with 'subcategory' then show products under that subcategory
  elseif ($productt->subcategory->category_relation->cs_category_type == 'App\Models\Subcategory') {
    $countCsProds = \App\Models\Product::where('subcategory_id', $productt->subcategory->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
  // if related with 'childcategory' then show products under that childcategory
  elseif ($productt->subcategory->category_relation->cs_category_type == 'App\Models\Childcategory') {
    $countCsProds = \App\Models\Product::where('childcategory_id', $productt->subcategory->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
}

// check if the product's category is in `cs_category_relations` table
elseif (!empty($productt->category->category_relation)) {

  $sType = $productt->category->category_relation->search_type;

  // if related with 'category' then show products under that category
  if ($productt->category->category_relation->cs_category_type == 'App\Models\Category') {
    $countCsProds = \App\Models\Product::where('category_id', $productt->category->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
  // if related with 'subcategory' then show products under that subcategory
  elseif ($productt->category->category_relation->cs_category_type == 'App\Models\Subcategory') {
    $countCsProds = \App\Models\Product::where('subcategory_id', $productt->category->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
  // if related with 'childcategory' then show products under that childcategory
  elseif ($productt->category->category_relation->cs_category_type == 'App\Models\Childcategory') {
    $countCsProds = \App\Models\Product::where('childcategory_id', $productt->category->category_relation->cs_category_id)
    ->when($sType == 'keyword', function ($query) use ($term) {
      return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
    })
    ->whereNotIn('id', $crossIds)->count();
  }
}

@endphp
<!-- Product Details Area Start -->
<section class="product-details-page">
  <div class="container">
    <div class="row">
    <div class="col-lg-12">
        <div class="row">

        <div class="col-lg-5 col-md-12">

          <div class="xzoom-container">
              <img class="xzoom5" id="xzoom-magnific" src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" xoriginal="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" />
              <div class="xzoom-thumbs">

                <div class="all-slider">

                    <a href="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}">
                  <img class="xzoom-gallery5" width="80" src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" title="The description goes here">
                    </a>

                @foreach($productt->galleries as $gal)


                    <a href="{{asset('assets/images/galleries/'.$gal->photo)}}">
                  <img class="xzoom-gallery5" width="80" src="{{asset('assets/images/galleries/'.$gal->photo)}}" title="The description goes here">
                    </a>

                @endforeach

                </div>

              </div>
          </div>

            </div>

            <div class="col-lg-7">
              <div class="right-area">
                <div class="product-info">
                  <h4 class="product-name">{{ $productt->name }}</h4>
                  <div class="info-meta-1">
                    <ul>

                      @if($productt->type == 'Physical')
                      @if($productt->emptyStock())
                      <!-- <li class="product-outstook">
                        <p>
                          <i class="icofont-close-circled"></i>
                          {{ __('Out Of Stock') }}
                        </p>
                      </li> -->
                      @else
                      <!-- <li class="product-isstook">
                        <p>
                          <i class="icofont-check-circled"></i>
                          {{ $gs->show_stock == 0 ? '' : $productt->stock }} {{ __('In Stock') }}
                        </p>
                      </li> -->
                      @endif
                      @endif
                      <li>
                        <div class="ratings">
                          <div class="empty-stars">
                          <span class="fa fa-star checked"></span>
                          <span class="fa fa-star checked"></span>
                          <span class="fa fa-star checked"></span>
                          <span class="fa fa-star checked"></span>
                          <span class="fa fa-star checked"></span>
                          </div>
                          <div class="full-stars" style="width:{{App\Models\Rating::ratings($productt->id)}}%"></div>
                        </div>
                      </li>
                      <li class="review-count">
                        <a href="#total-reviews-view"><p>{{count($productt->ratings)}} {{ __('Review(s)') }}</p></a>
                      </li>
                  
                    </ul>
                  </div>



            <div class="product-price">
              <p class="title">{{ __('Price') }} :</p>
                    <p class="price"><span id="sizeprice">{{ $productt->convertPrice($productt->vendorSizePrice()) }}</span>
                      <small><del>{{ $productt->showPreviousPrice() }}</del></small></p>
                      @if($productt->youtube != null)
                      <!-- <a href="{{ $productt->youtube }}" class="video-play-btn mfp-iframe">
                        <i class="fas fa-play"></i>
                      </a> -->
                    @endif
                  </div>

                  <div class="info-meta-2">
                    <ul>

                      

                    </ul>
                  </div>


                  @if(!empty($productt->size))
                  <div class="product-size">
                    <p class="title">{{ __('Size') }} :</p>
                    <ul class="siz-list">
                      @php
                      $is_first = true;
                      @endphp
                      @foreach($productt->size as $key => $data1)
                      <li class="{{ $is_first ? 'active' : '' }}">
                        <span class="box">{{ $data1 }}
                          <input type="hidden" class="size" value="{{ $data1 }}">
                          <input type="hidden" class="size_qty" value="{{ $productt->size_qty[$key] }}">
                          <input type="hidden" class="size_key" value="{{$key}}">
                          <input type="hidden" class="size_price"
                            value="{{ round($productt->size_price[$key] * $curr->value,2) }}">
                        </span>
                      </li>
                      @php
                      $is_first = false;
                      @endphp
                      @endforeach
                      <li>
                    </ul>
                  </div>
                  @endif

                  @if(!empty($productt->color))
                  <div class="product-color">
                    <p class="title">{{ __('Color') }} :</p>
                    <ul class="color-list">
                      @php
                      $is_first = true;
                      @endphp
                      @foreach($productt->color as $key => $data1)
                      <li class="{{ $is_first ? 'active' : '' }}">
                        <span class="box" data-color="{{ $productt->color[$key] }}" style="background-color: {{ $productt->color[$key] }}"></span>
                      </li>
                      @php
                      $is_first = false;
                      @endphp
                      @endforeach

                    </ul>
                  </div>
                  @endif

                  @if(!empty($productt->size))

                  <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
                  @else
                  @php
                  $stck = (string)$productt->stock;
                  @endphp
                  @if($stck != null)
                  <input type="hidden" id="stock" value="{{ $stck }}">
                  @elseif($productt->type != 'Physical')
                  <input type="hidden" id="stock" value="0">
                  @else
                  <input type="hidden" id="stock" value="">
                  @endif

                  @endif
                  <input type="hidden" id="product_price" value="{{ round($productt->vendorPrice() * $curr->value,2) }}">

                  <input type="hidden" id="product_id" value="{{ $productt->id }}">
                  <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                  <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">
                  <div class="info-meta-3">
                    <ul class="meta-list">
                      @if($productt->product_type != "affiliate")
                      <li class="d-block count {{ $productt->type == 'Physical' ? '' : 'd-none' }}">
                        <div class="qty">
                          <ul>
                            <li>
                              <span class="qtminus">
                                <i class="icofont-minus"></i>
                              </span>
                            </li>
                            <li>
                              <span class="qttotal" data="{{$productt->min_qty}}">{{$productt->min_qty}}</span>
                            </li>
                            <li>
                              <span class="qtplus">
                                <i class="icofont-plus"></i>
                              </span>
                            </li>
                          </ul>
                        </div>
                      </li>
                      @endif

                      @if (!empty($productt->attributes))
                        @php
                          $attrArr = json_decode($productt->attributes, true);
                        @endphp
                      @endif
                      @if (!empty($attrArr))
                        <div class="product-attributes my-4">
                          <div class="row">
                          @foreach ($attrArr as $attrKey => $attrVal)
                            @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)

                          <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <strong for="" class="text-capitalize">{{ str_replace("_", " ", $attrKey) }} :</strong>
                                <div class="">
                                @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                  <div class="custom-control custom-radio">
                                    <input type="hidden" class="keys" value="">
                                    <input type="hidden" class="values" value="">
                                    <input type="radio" id="{{$attrKey}}{{ $optionKey }}" name="{{ $attrKey }}" class="custom-control-input product-attr"  data-key="{{ $attrKey }}" data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}" value="{{ $optionVal }}" {{ $loop->first ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="{{$attrKey}}{{ $optionKey }}">{{ $optionVal }}

                                    @if (!empty($attrVal['prices'][$optionKey]))
                                      +
                                      {{$curr->sign}} {{round($attrVal['prices'][$optionKey] * $curr->value,2)}}
                                    @endif
                                    </label>
                                  </div>
                                @endforeach
                                </div>
                              </div>
                          </div>
                            @endif
                          @endforeach
                          </div>
                        </div>
                      @endif

                      @if($productt->product_type == "affiliate")

                      <li class="addtocart">
                        <a href="{{ route('affiliate.product', $productt->slug) }}" target="_blank"><i
                            class="icofont-cart"></i> {{__('Buy Now') }}</a>
                      </li>
                      @else
                      @if($productt->emptyStock())
                      <li class="addtocart">
                        <a href="javascript:;" class="cart-out-of-stock">
                          <i class="icofont-close-circled"></i>
                          {{ __('Out Of Stock') }}</a>
                      </li>
                      @else
                      @if (($productt->cross_selling_products()->count() + $countCsProds) > 0)
                        <!--<span class="hidden-add-to-cart" data-href="{{ route('product.cart.add',$productt->id) }}"  rel1="" rel=""  ></span>-->
                        <!--  <span class="crosssell-btn crosssell-view" data-cs_href="{{route('product.cross-sell',$productt->id)}}">-->
                        <!--    <i class="icofont-cart"></i> {{ __('Add To Cart') }}-->
                        <!--  </span>-->
                          <li class="addtocart">
                            <a href="javascript:;" id="addcrt"><i class="icofont-cart"></i>{{ __('Add to Cart') }}</a>
                          </li>
                         
                      @else

                      <li class="addtocart">
                        <a href="javascript:;" id="addcrt"><i class="icofont-cart"></i>{{ __('Add to Cart') }}</a>
                      </li>

                      <!-- <li class="addtocart">
                        <a id="qaddcrt" href="javascript:;">
                          <i class="icofont-cart"></i>{{ __('Buy Now')}}
                        </a>
                      </li> -->
                      @endif
                      @endif

                      @endif

                      @if(Auth::guard('web')->check())
                      <li class="favorite">
                        <a href="javascript:;" class="add-to-wish"
                          data-href="{{ route('user-wishlist-add',$productt->id) }}"><i class="icofont-heart-alt"></i></a>
                      </li>
                      @else
                      <li class="favorite">
                        <a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg" id="wish-btn"><i
                            class="icofont-heart-alt"></i></a>
                      </li>
                      @endif
                      <!-- <li class="compare">
                        <a href="javascript:;" class="add-to-compare"
                          data-href="{{ route('product.compare.add',$productt->id) }}"><i class="icofont-exchange"></i></a>
                      </li> -->
                    </ul>
                  </div>
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


                  @if($productt->ship != null)
                    <p class="estimate-time">{{ __('Estimated Shipping Time') }}: <b> {{ $productt->ship }}</b></p>
                  @endif
                  @if( $productt->sku != null )
                  <p class="p-sku">
                    {{ __('Product SKU') }}: <span class="idno">{{ $productt->sku }}</span>
                  </p>
                  @endif
      @if($gs->is_report)

      {{-- PRODUCT REPORT SECTION --}}

                    @if(Auth::guard('web')->check())

                 

                    @else

                    
                    @endif

      {{-- PRODUCT REPORT SECTION ENDS --}}

      @endif

                <div class="wd-after-add-to-cart">
									<div class="pbottom-paymnt-icon">
                    <h4>Guaranteed safe checkout</h4>
                    <img class="payment-method" src="{{asset('assets/front/images/product-payment.png')}}">
                  </div>							
                </div>

                <div class="product_meta">
                  <span class="posted_in">Category: <a href="{{route('front.category', $productt->category->slug)}}" rel="tag"><b>{{ $productt->category->name }}</b></a></span>
	              </div>



                </div>
              </div>
            </div>

          </div>
          

          <!-------------------------------description------------------------------>
          <section class="about-product-description">
                <div class="container">
                  <div class="row">
                    <div class="col-sm-12 col-md-12 p-0 m-0">
                      <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                        <!-- Accordion card -->
                        <div class="card products-card">
                          <!-- Card header -->
                          <div class="card-header single-product-header" role="tab" id="headingOne1">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1" class="collapsed">
                              <h5 class="about-pro-head mb-0">DESCRIPTION <i class="fa fa-angle-down rotate-icon float-right"></i>
                              </h5>
                            </a>
                          </div>
                          <!-- Card body -->
                          <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx" style="">
                            <div class="card-body single-product-body">
                              <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="description-details">
                                        <p>{!! $productt->details !!}</p>
                                    </div>    
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Accordion card -->
                      </div>
                    </div>
                  </div>

                  <div id="total-reviews-view">
                  <div class="row"> <div class="col-lg-12 remove-padding"> <div class="section-top"> <h2 class="related-pro-title"> REVIEWS </h2> </div> </div> </div>
                  <div class="row">
                      <div class="col-sm-6 pl-0">
                        <div class="comment">
                            <h2 class="woocommerce-Reviews-title" style="color: #fff;"><span class="bgss">{{App\Models\Rating::rating($productt->id)}}<i class="fas fa-star"></i></span></h2>

                            <!-- <div class="stars"><span id="star-rating">0.0</span> <i class="fas fa-star"></i></div> -->
                            <ol class="commentlist">
                            @if(count($productt->ratings) > 0)
                            @foreach($productt->ratings as $review)
                                <li class="reviews">
                                    <div class="comment_container">
                                        <img alt="" src="{{ $review->user->photo ? asset('assets/images/users/'.$review->user->photo):asset('assets/images/noimage.png') }}" class="avatar avatar-60 photo" height="60" width="60">
                                        <div class="comment-text">
                                            <div class="rating">
                                                <div class="stars">
                                                  <?php
                                                  for($i=1;$i<=$review->rating;$i++){
                                                  ?>
                                                    <span class="fa fa-star checked"></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="comment-two">
                                                <h6><b>{{ $review->user->name }}</b></h6>
                                                <p>{{$review->review}}</p>
                                            </div>
                                        </div>
                                      </div>
                                </li>
                                @endforeach
                                @else
                            <p>{{ __('No Review Found.') }}</p>
                            @endif
                            </ol>
                        </div>
                      </div>
                      <div class="col-sm-6 pr-0">
                        <div class="review-form">
                            <h2 class="woocommerce-Reviews-title">ADD A REVIEW</h2>
                            @if(Auth::guard('web')->check())
                          <div class="review-area">
                            <div class="star-area">
                              <ul class="star-list">
                                <li class="stars" data-val="1">
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="2">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="3">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="4">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars active" data-val="5">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="write-comment-area">
                            <div class="gocover"
                              style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            <form id="reviewform" action="{{route('front.review.submit')}}"
                              data-href="{{ route('front.reviews',$productt->id) }}" method="POST">
                              @include('includes.admin.form-both')
                              {{ csrf_field() }}
                              <input type="hidden" id="rating" name="rating" value="5">
                              <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
                              <input type="hidden" name="product_id" value="{{$productt->id}}">
                              <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="usr" class="labels">Your review *</label>
                                            <textarea class="form-control" rows="5" id="comment" name="review" placeholder="" required></textarea>
                                        </div>
                                    </div>
                                </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  <button class="submit-btn" type="submit">{{ __('SUBMIT') }}</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          @else
                          <div class="row">
                            <div class="col-lg-12">
                              <br>
                              <h5 class="to-reviews-text text-left"><a href="{{route('user.login')}}"
                                  class="btn login-btns mr-1">{{ __('Login') }}</a> {{ __('To Review') }}</h5>
                              <br>
                            </div>
                          </div>
                          @endif
                            
                        </div>  
                    </div>
                  </div>
                  </div>
                </div>
            </section>





          </div>
    
    <div class="row">
      <div class="col-lg-12">

      </div>
    </div>
  </div>
  <!-- Trending Item Area Start -->
<div class="trending">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 remove-padding">
        <div class="section-top">
          <h2 class="related-pro-title">
            {{ __('Related Products') }}
          </h2>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-md-12">
        <div id="" class="owl-carousel news-slider">
        @foreach($productt->category->products()->where('status','=',1)->where('id','!=',$productt->id)->take(8)->get() as $prod)
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
</div>
<!-- Tranding Item Area End -->
</section>
<!-- Product Details Area End -->






@if($gs->is_report)

@if(Auth::check())

{{-- REPORT MODAL SECTION --}}

<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

 <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                    <div class="login-area">
                        <div class="header-area forgot-passwor-area">
                            <h4 class="title">{{ __('REPORT PRODUCT') }}</h4>
                            <p class="text">{{__('Please give the following details') }}</p>
                        </div>
                        <div class="login-form">

                            <form id="reportform" action="{{ route('product.report') }}" method="POST">

                              @include('includes.admin.form-login')

                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                <div class="form-input">
                                    <input type="text" name="title" class="User Name" placeholder="{{ __('Enter Report Title') }}" required="">
                                    <i class="icofont-notepad"></i>
                                </div>

                                <div class="form-input">
                                  <textarea name="note" class="User Name" placeholder="{{ __('Enter Report Note') }}" required=""></textarea>
                                </div>

                                <button type="submit" class="submit-btn">{{ __('SUBMIT') }}</button>
                            </form>
                        </div>
                    </div>
      </div>
    </div>
  </div>
</div>

{{-- REPORT MODAL SECTION ENDS --}}

@endif

@endif

@endsection


@section('scripts')

<script type="text/javascript">
  lazy();
  $(document).on("submit", "#emailreply1", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var $type  = $(this).find('input[name=type]').val();
    $('#subj1').prop('disabled', true);
    $('#msg1').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "{{URL::to('/user/admin/user/send/message')}}",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'type'   : $type
      },
      success: function (data) {
        $('#subj1').prop('disabled', false);
        $('#msg1').prop('disabled', false);
        $('#subj1').val('');
        $('#msg1').val('');
        $('#emlsub').prop('disabled', false);
        if(data == 0)
          toastr.error("Oops Something Goes Wrong !!");
        else
          toastr.success("Message Sent !!");
        $('.close').click();
      }

    });
    return false;
  });

</script>


<script type="text/javascript">

  $(document).on("submit", "#emailreply", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var email = $(this).find('input[name=email]').val();
    var name = $(this).find('input[name=name]').val();
    var user_id = $(this).find('input[name=user_id]').val();
    var vendor_id = $(this).find('input[name=vendor_id]').val();
    $('#subj').prop('disabled', true);
    $('#msg').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "{{URL::to('/vendor/contact')}}",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'email': email,
        'name': name,
        'user_id': user_id,
        'vendor_id': vendor_id
      },
      success: function () {
        $('#subj').prop('disabled', false);
        $('#msg').prop('disabled', false);
        $('#subj').val('');
        $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        toastr.success("{{ __('Message Sent !!') }}");
        $('.ti-close').click();
      }
    });
    return false;
  });

</script>

@endsection
