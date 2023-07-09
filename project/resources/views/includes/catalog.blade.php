<div class="col-sm-3 col-md-3">
    <div class="product-category">
        <div class="widget widget-category filter-category">
            <div class="widget-title">
              <h2 class=" mb-0">Products Categories</h2>
            </div>
            <div class="widget-content">
            <form id="catalogForm" action="{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}" method="GET">
                @if (!empty(request()->input('search')))
                  <input type="hidden" name="search" value="{{ request()->input('search') }}">
                @endif
                @if (!empty(request()->input('sort')))
                  <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
                @endif
              <ul class="list-category-toggle toggle-tab list-none">
              
                  @foreach ($categories as $element)
                  
                  <li class="item-toggle-tab">
                    <div class="content">
                    <a href="{{route('front.category', $element->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}"><i class="fas fa-angle-double-right"></i>{{$element->name}}</a>
                        
                        @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
                            @foreach ($cat->subs as $key => $subelement)
                            <div class="sub-content open">
                              <a href="{{route('front.category', [$cat->slug, $subelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="subcategory-link"><i class="fas fa-angle-right"></i>{{$subelement->name}}</a>
                              @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                                @foreach ($subcat->childs as $key => $childcat)
                                <div class="child-content open">
                                  <a href="{{route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}" class="subcategory-link"><i class="fas fa-caret-right"></i> {{$childcat->name}}</a>
                                </div>
                                @endforeach
                              @endif
                            </div>
                            @endforeach

                          </div>
                        @endif


                  </li>
                  @endforeach

              </ul>
              <div class="price-range-block">
                <div id="slider-range" class="price-filter-range d-none" name="rangeInput"></div>
                <div class="livecount">
                  <input type="hidden" min=0  name="min"  id="min_price" class="price-range-field" />
                  <!-- <span>{{__('To')}}</span> -->
                  <input type="hidden" min=0  name="max" id="max_price" class="price-range-field" />
                </div>
              </div>

                  <!-- <button class="filter-btn" type="submit">{{__('Search')}}</button> -->
              </form>
            </div>
          </div>
    </div>
</div>
        
