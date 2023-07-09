@if(Auth::guard('admin')->user()->role_id != 0)

@if(Auth::guard('admin')->user()->sectionCheck('orders'))

    <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
               <li>
                <a href="{{route('admin-order-index')}}"> {{ __('All Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-order-pending')}}"> {{ __('Pending Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-order-processing')}}"> {{ __('Processing Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-order-completed')}}"> {{ __('Completed Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-order-declined')}}"> {{ __('Declined Orders') }}</a>
            </li>  
            <li>
                <a href="{{route('admin-order-refund')}}"> {{ __('Refund Orders') }}</a>
            </li>  

        </ul>
    </li>

@endif

@if(Auth::guard('admin')->user()->sectionCheck('custom_tea_order'))

    <li>
        <a href="#customtea-order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Custom Tea Orders') }}</a>
        <ul class="collapse list-unstyled" id="customtea-order" data-parent="#accordion" >
            <li>
                <a href="{{route('admin-customtea-order-index')}}"> {{ __('All Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-customtea-local-order-index')}}"> {{ __('Local Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-customtea-order-pending')}}"> {{ __('Pending Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-customtea-order-processing')}}"> {{ __('Processing Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-customtea-order-delivered')}}"> {{ __('Delivered Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-customtea-order-completed')}}"> {{ __('Completed Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-customtea-order-declined')}}"> {{ __('Declined Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-customtea-total-sold-order')}}"> {{ __('Total Sold Orders') }}</a>
            </li> 
             

        </ul>
    </li>

@endif


@if(Auth::guard('admin')->user()->sectionCheck('commission'))

<!-- <li>
    <a href="#income" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Total Earning') }}</a>
    <ul class="collapse list-unstyled" id="income" data-parent="#accordion" >
        <li>
            <a href="{{route('admin-tax-calculate-income')}}"> {{ __('Tax Calculate') }}</a>
        </li>
        <li>
            <a href="{{route('admin-subscription-income')}}"> {{ __('Subscription Earning') }}</a>
        </li>
    
        <li>
            <a href="{{route('admin-withdraw-income')}}"> {{ __('Withdraw Earning') }}</a>
        </li>
    
        <li>
            <a href="{{route('admin-commission-income')}}"> {{ __('Commission Earning') }}</a>
        </li>
       
    </ul>
</li> -->
@endif




@if(Auth::guard('admin')->user()->sectionCheck('products'))

    <li>
        <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-cart"></i>{{ __('Products') }}
        </a>
        <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-prod-types') }}"><span>{{ __('Add New Product') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-prod-index') }}"><span>{{ __('All Products') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-prod-deactive') }}"><span>{{ __('Deactivated Product') }}</span></a>
            </li>
            <!-- <li>
                <a href="{{ route('admin-prod-catalog-index') }}"><span>{{ __('Product Catalogs') }}</span></a>
            </li> -->
        </ul>
    </li>

@endif





@if(Auth::guard('admin')->user()->sectionCheck('customers'))

    <li>
        <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i>{{ __('Customers') }}
        </a>
        <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a>
            </li>
        </ul>
    </li>

@endif



@if(Auth::guard('admin')->user()->sectionCheck('categories'))

    <li>
        <a href="#menu5" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sitemap"></i>{{ __('Manage Categories') }}</a>
        <ul class="collapse list-unstyled
        @if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory')
          show
        @endif" id="menu5" data-parent="#accordion" >
                <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category') active @endif">
                    <a href="{{ route('admin-cat-index') }}"><span>{{ __('Main Category') }}</span></a>
                </li>
                <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory') active @endif">
                    <a href="{{ route('admin-subcat-index') }}"><span>{{ __('Sub Category') }}</span></a>
                </li>
                <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory') active @endif">
                    <a href="{{ route('admin-childcat-index') }}"><span>{{ __('Child Category') }}</span></a>
                </li>
        </ul>
    </li>

@endif



@if(Auth::guard('admin')->user()->sectionCheck('product_discussion'))

    <li>
        <a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-speech-comments"></i>{{ __('Product Discussion') }}
        </a>
        <ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-rating-index') }}"><span>{{ __('Product Reviews') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-comment-index') }}"><span>{{ __('Comments') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-report-index') }}"><span>{{ __('Reports') }}</span></a>
            </li>
        </ul>
    </li>

@endif

@if(Auth::guard('admin')->user()->sectionCheck('set_coupons'))

    <!-- <li>
        <a href="{{ route('admin-coupon-index') }}" class=" wave-effect"><i class="fas fa-percentage"></i>{{ __('Set Coupons') }}</a>
    </li> -->

@endif

@if(Auth::guard('admin')->user()->sectionCheck('blog'))

    <!-- <li>
        <a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-fw fa-newspaper"></i>{{ __('Blog') }}
        </a>
        <ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-cblog-index') }}"><span>{{ __('Categories') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-blog-index') }}"><span>{{ __('Posts') }}</span></a>
            </li>
        </ul>
    </li> -->

@endif





@if(Auth::guard('admin')->user()->sectionCheck('general_settings'))

    <li>
        <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-cogs"></i>{{ __('General Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-gs-logo') }}"><span>{{ __('Logo') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-gs-fav') }}"><span>{{ __('Favicon') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-gs-load') }}"><span>{{ __('Loader') }}</span></a>
            </li>
            <!-- <li>
                <a href="{{ route('admin-shipping-index') }}"><span>{{ __('Shipping Methods') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-package-index') }}"><span>{{ __('Packagings') }}</span></a>
            </li> -->
            <li>
                <a href="{{ route('admin-pick-index') }}"><span>{{ __('Local Pincode') }}</span></a>
            </li>
            <li>
            <a href="{{ route('admin-gs-contents') }}"><span>{{ __('Website Contents') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-gs-footer') }}"><span>{{ __('Footer') }}</span></a>
            </li>
            <!-- <li>
                <a href="{{ route('admin-gs-affilate') }}"><span>{{__('Affiliate Information')}}</span></a>
            </li> -->

            <li>
                <a href="{{ route('admin-gs-popup') }}"><span>{{ __('Popup Banner') }}</span></a>
            </li>

            <!-- <li>
                <a href="{{ route('admin-gs-newsletter-banner') }}"><span>{{ __('Newsletter Banner') }}</span></a>
            </li> -->

            <li>
                <a href="{{ route('admin-gs-login-background') }}"><span>{{ __('Login Page Background') }}</span></a>
            </li>

            <li>
                <a href="{{ route('admin-gs-error-banner') }}"><span>{{ __('Error Banner') }}</span></a>
            </li>


            <li>
                <a href="{{ route('admin-gs-maintenance') }}"><span>{{ __('Website Maintenance') }}</span></a>
            </li>

        </ul>
    </li>

@endif

@if(Auth::guard('admin')->user()->sectionCheck('home_page_settings'))

    <li>
        <a href="#homepage" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-edit"></i>{{ __('Home Page Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="homepage" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-sl-index') }}"><span>{{ __('Sliders') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-service-index') }}"><span>{{ __('Services') }}</span></a>
            </li>
            <!--<li>-->
            <!--    <a href="{{ route('admin-ps-slider-right') }}"><span>{{ __('Slider Right Side Banner') }}</span></a>-->
            <!--</li>-->
            <li>
                <a href="{{ route('admin-ps-gallary-large') }}"><span>{{ __('Gallery Large Banner') }}</span></a>
            </li>
            <!--<li>-->
            <!--    <a href="{{ route('admin-ps-gallary-small') }}"><span>{{ __('Gallery Small Banner') }}</span></a>-->
            <!--</li>-->
            <!--<li>-->
            <!--    <a href="{{ route('admin-ps-best-seller') }}"><span>{{ __('Right Side Banner1') }}</span></a>-->
            <!--</li>-->
            <!--<li>-->
            <!--    <a href="{{ route('admin-ps-big-save') }}"><span>{{ __('Right Side Banner2') }}</span></a>-->
            <!--</li>-->
            <!--<li>-->
            <!--    <a href="{{ route('admin-sb-index') }}"><span>{{ __('Top Small Banners') }}</span></a>-->
            <!--</li>-->

            <!--<li>-->
            <!--    <a href="{{ route('admin-sb-large') }}"><span>{{ __('Large Banners') }}</span></a>-->
            <!--</li>-->
            <!--<li>-->
            <!--    <a href="{{ route('admin-sb-bottom') }}"><span>{{ __('Bottom Small Banners') }}</span></a>-->
            <!--</li>-->

            <!--<li>-->
            <!--    <a href="{{ route('admin-review-index') }}"><span>{{ __('Reviews') }}</span></a>-->
            <!--</li>-->
            <!--<li>-->
            <!--    <a href="{{ route('admin-partner-index') }}"><span>{{ __('Partners') }}</span></a>-->
            <!--</li>-->

            
            <!-- <li>
                <a href="{{ route('admin-ps-customize') }}"><span>{{ __('Home Page Customization') }}</span></a>
            </li> -->
        </ul>
    </li>

@endif


@if(Auth::guard('admin')->user()->sectionCheck('menu_page_settings'))

    <li>
        <a href="#menu" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-file-code"></i>{{ __('Menu Page Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="menu" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-faq-index') }}"><span>{{ __('FAQ Page') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-ps-contact') }}"><span>{{ __('Contact Us Page') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-page-index') }}"><span>{{ __('Other Pages') }}</span></a>
            </li>
        </ul>
    </li>

@endif


@if(Auth::guard('admin')->user()->sectionCheck('emails_settings'))

    <li>
        <a href="#emails" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-at"></i>{{ __('Email Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="emails" data-parent="#accordion">
            <li><a href="{{route('admin-mail-index')}}"><span>{{ __('Email Template') }}</span></a></li>  
            <li><a href="{{route('admin-mail-config')}}"><span>{{ __('Email Configurations') }}</span></a></li>  
            <li><a href="{{route('admin-group-show')}}"><span>{{ __('Group Email') }}</span></a></li>  
        </ul>
    </li>

@endif


@if(Auth::guard('admin')->user()->sectionCheck('payment_settings'))

    <li>
        <a href="#payments" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-file-code"></i>{{ __('Payment Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="payments" data-parent="#accordion">
            <li><a href="{{route('admin-reward-index')}}"><span>{{__('Reward Information')}}</span></a></li>
            <li><a href="{{route('admin-gs-payments')}}"><span>{{__('Payment Information')}}</span></a></li>  
            <li><a href="{{route('admin-payment-index')}}"><span>{{ __('Payment Gateways') }}</span></a></li>  
            <!-- <li><a href="{{route('admin-currency-index')}}"><span>{{ __('Currencies') }}</span></a></li>   -->
        </ul>
    </li>

@endif

@if(Auth::guard('admin')->user()->sectionCheck('social_settings'))

    <li>
        <a href="#socials" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-paper-plane"></i>{{ __('Social Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="socials" data-parent="#accordion">
                <li><a href="{{route('admin-social-index')}}"><span>{{ __('Social Links') }}</span></a></li>   
                <!-- <li><a href="{{route('admin-social-facebook')}}"><span>{{ __('Facebook Login') }}</span></a></li>
                <li><a href="{{route('admin-social-google')}}"><span>{{ __('Google Login') }}</span></a></li> -->
        </ul>
    </li>

@endif




@if(Auth::guard('admin')->user()->sectionCheck('seo_tools'))

    <li>
        <a href="#seoTools" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-wrench"></i>{{ __('SEO Tools') }}
        </a>
        <ul class="collapse list-unstyled" id="seoTools" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-seotool-pixels') }}"><span>{{ __('Facebook Pixel') }}</span></a>
            </li>
            
            <li>
                <a href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a>
            </li>
        </ul>
    </li>

@endif

@if(Auth::guard('admin')->user()->sectionCheck('manage_staffs'))


    <li>
        <a href="{{ route('admin-staff-index') }}" class=" wave-effect"><i class="fas fa-user-secret"></i>{{ __('Manage Staffs') }}</a>
    </li>

@endif





@endif