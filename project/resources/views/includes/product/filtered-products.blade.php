


				@if (count($prods) > 0)
					@foreach ($prods as $key => $prod)

					@php
					// dd($prod->cross_selling_products);
					$crossIds = [];
					foreach ($prod->cross_selling_products as $crProd) {
						$crossIds[] = $crProd->cross_selling_product_id;
					}

					$countCsProds = 0;
					$term = Str::slug($prod->name, ' ');

					// check if the product's childcategory is in `cs_category_relations` table
					if (!empty($prod->childcategory->category_relation)) {

						$sType = $prod->childcategory->category_relation->search_type;

						// if related with 'category' then show products under that category
						if ($prod->childcategory->category_relation->cs_category_type == 'App\Models\Category') {
							$countCsProds = \App\Models\Product::where('category_id', $prod->childcategory->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();

						}
						// if related with 'subcategory' then show products under that subcategory
						elseif ($prod->childcategory->category_relation->cs_category_type == 'App\Models\Subcategory') {
							$countCsProds = \App\Models\Product::where('subcategory_id', $prod->childcategory->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
						// if related with 'childcategory' then show products under that childcategory
						elseif ($prod->childcategory->category_relation->cs_category_type == 'App\Models\Childcategory') {
							$countCsProds = \App\Models\Product::where('childcategory_id', $prod->childcategory->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
					}

					// check if the product's subcategory is in `cs_category_relations` table
					elseif (!empty($prod->subcategory->category_relation)) {

						$sType = $prod->subcategory->category_relation->search_type;

						// if related with 'category' then show products under that category
						if ($prod->subcategory->category_relation->cs_category_type == 'App\Models\Category') {
							$countCsProds = \App\Models\Product::where('category_id', $prod->subcategory->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
						// if related with 'subcategory' then show products under that subcategory
						elseif ($prod->subcategory->category_relation->cs_category_type == 'App\Models\Subcategory') {
							$countCsProds = \App\Models\Product::where('subcategory_id', $prod->subcategory->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
						// if related with 'childcategory' then show products under that childcategory
						elseif ($prod->subcategory->category_relation->cs_category_type == 'App\Models\Childcategory') {
							$countCsProds = \App\Models\Product::where('childcategory_id', $prod->subcategory->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
					}

					// check if the product's category is in `cs_category_relations` table
					elseif (!empty($prod->category->category_relation)) {

						$sType = $prod->category->category_relation->search_type;

						// if related with 'category' then show products under that category
						if ($prod->category->category_relation->cs_category_type == 'App\Models\Category') {
							$countCsProds = \App\Models\Product::where('category_id', $prod->category->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
						// if related with 'subcategory' then show products under that subcategory
						elseif ($prod->category->category_relation->cs_category_type == 'App\Models\Subcategory') {
							$countCsProds = \App\Models\Product::where('subcategory_id', $prod->category->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
						// if related with 'childcategory' then show products under that childcategory
						elseif ($prod->category->category_relation->cs_category_type == 'App\Models\Childcategory') {
							$countCsProds = \App\Models\Product::where('childcategory_id', $prod->category->category_relation->cs_category_id)
							->when($sType == 'keyword', function ($query) use ($term) {
								return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($term));
							})
							->whereNotIn('id', $crossIds)->count();
						}
					}

					@endphp
					
							<div class="col-sm-4 my-grid">
								<div class="products-grid">
									<div class="product-img">
									<img src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" class="img-fluid shop-img" alt="">
									<a href="{{ route('front.product', $prod->slug) }}" class="over-layers"></a>
									</div>
									<div class="product-content">
										<a href="{{ route('front.product', $prod->slug) }}"><h2 class="p-name">{{ $prod->showName() }}</h2></a>  
										<p class="p-des">{{ $prod->showDescription() }}</p>
										<h6 class="category">Tea</h6>
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
										<a href="javascript:void('0')" class="btn addtocart add-to-cart add-to-cart-btn" data-href="{{ route('product.cart.add',$prod->id) }}">Add To Cart</a></div>
									</div>
								</div>
							</div>
						

									
				@endforeach
				<div class="col-lg-12">
					<div class="page-center mt-5">
						{!! $prods->appends(['search' => request()->input('search')])->links() !!}
					</div>
				</div>
			@else
				<div class="col-lg-12">
					<div class="page-center">
						 <h4 class="text-center">{{ __('No Product Found.') }}</h4>
					</div>
				</div>
			@endif


@if(isset($ajax_check))


<script type="text/javascript">


// Tooltip Section


    $('[data-toggle="tooltip"]').tooltip({
      });
      $('[data-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });




      $('[rel-toggle="tooltip"]').tooltip();

      $('[rel-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });


// Tooltip Section Ends

</script>

@endif
