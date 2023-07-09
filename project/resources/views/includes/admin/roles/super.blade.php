<!-- 
   <li>
    <a href="#menu1" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-flag"></i>{{ __('Manage Country') }}
    </a>
    <ul class="collapse list-unstyled" id="menu1" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-country-index') }}"><span>{{ __('Country') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-country-tax') }}"><span>{{ __('Manage Tax') }}</span></a>
        </li>
    </ul>
</li> -->

<li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
            <li>
                <a href="{{route('admin-order-index')}}"> {{ __('All Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-local-order-index')}}"> {{ __('Local Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-order-pending')}}"> {{ __('Pending Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-order-processing')}}"> {{ __('Processing Orders') }}</a>
            </li>
            <li>
                <a href="{{route('admin-order-delivered')}}"> {{ __('Delivered Orders') }}</a>
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
            <li>
                <a href="{{route('admin-total-sold-order')}}"> {{ __('Total Sold Orders') }}</a>
            </li>   

        </ul>
    </li>
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

    <!-- <li>
        <a href="#commission" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Manage Commission') }}</a>
            <ul class="collapse list-unstyled" id="commission" data-parent="#accordion" >
                <li>
                    <a href="{{route('admin-main-commission-index')}}"> {{ __('Main Commission') }}</a>
                </li>
                <li>
                    <a href="{{route('admin-category-commission-index')}}"> {{ __('Category Commission') }}</a>
                </li>
            </ul>
    </li> -->

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
    <li>
        <a href="#customtea" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fa fa-coffee"></i>{{ __('Custom Tea') }}
        </a>
        <ul class="collapse list-unstyled" id="customtea" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-prod-customtea-create') }}"><span>{{ __('Add New Product') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-smell-prod-index') }}"><span>{{ __('Smell Products') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-colour-prod-index') }}"><span>{{ __('Colour Product') }}</span></a>
            </li>
           
           
        </ul>
    </li>

    <!-- <li>
        <a href="#affiliateprod" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-cart"></i>{{ __('Affiliate Products') }}
        </a>
        <ul class="collapse list-unstyled" id="affiliateprod" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-import-create') }}"><span>{{ __('Add Affiliate Product') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-import-index') }}"><span>{{ __('All Affiliate Products') }}</span></a>
            </li>
        </ul>
    </li> -->

    <li>
        <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i>{{ __('Customers') }}
        </a>
        <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a>
            </li>
          	<li>
                <a href="{{ route('admin-domestic-user') }}"><span>{{ __('Domestic Customers') }}</span></a>
            </li>
          	<li>
                <a href="{{ route('admin-commercial-user') }}"><span>{{ __('Commercial Customers') }}</span></a>
            </li>
            <!-- <li>
                <a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a>
            </li> -->
            <li>
                <a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-user-cashback') }}"><span>{{ __('Customer cashback') }}</span></a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#delivery-boy" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i>{{ __('Delivery Partner') }}
        </a>
        <ul class="collapse list-unstyled" id="delivery-boy" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-deliveryboys-create') }}"><span>{{ __('Add New Delivery Partner') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-deliveryboys-index') }}"><span>{{ __('Delivery Partner List') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-deliveryboys-commission') }}"><span>{{ __('Delivery Partner Commission') }}</span></a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#sales-person" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i>{{ __('Sales Person') }}
        </a>
        <ul class="collapse list-unstyled" id="sales-person" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-salesperson-create') }}"><span>{{ __('Add New Sales Person') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-salesperson-index') }}"><span>{{ __('Sales Person List') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-salesperson-commission') }}"><span>{{ __('Sales Person Commission') }}</span></a>
            </li>
            <li>
                <a href="{{route('admin-salesperson-total-sold-order')}}"> {{ __('Total Sold Orders') }}</a>
            </li> 
        </ul>
    </li>

    <!-- <li>
        <a href="#vendor" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-ui-user-group"></i>{{ __('Vendors') }}
        </a>
        <ul class="collapse list-unstyled" id="vendor" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-vendor-index') }}"><span>{{ __('Vendors List') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-vendor-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-vendor-subs') }}"><span>{{ __('Vendor Subscriptions') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-vendor-color') }}"><span>{{ __('Default Background') }}</span></a>
            </li>

        </ul>
    </li> -->

    <!-- <li>
        <a href="#vendor1" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                <i class="icofont-verification-check"></i>{{ __('Vendor Verifications') }}
        </a>
        <ul class="collapse list-unstyled" id="vendor1" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-vr-index') }}"><span>{{ __('All Verifications') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-vr-pending') }}"><span>{{ __('Pending Verifications') }}</span></a>
            </li>
        </ul>
    </li> -->


    

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


    <!-- <li>
        <a href="#relation" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sitemap"></i>{{ __('Cross Selling Relations') }}</a>
        <ul class="collapse list-unstyled
        @if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory')
          show
        @endif" id="relation" data-parent="#accordion" >
            <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category') active @endif">
                <a href="{{ route('admin-csrelation-create') }}"><span>{{ __('Create Relation') }}</span></a>
            </li>
            <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory') active @endif">
                <a href="{{ route('admin-csrelation-index') }}"><span>{{ __('Relations') }}</span></a>
            </li>
        </ul>
    </li> -->
    

    <!-- <li>
        <a href="{{ route('admin-prod-import') }}"><i class="fas fa-upload"></i>{{ __('Bulk Product Upload') }}</a>
    </li> -->

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

    <li>
        <!-- <a href="{{ route('admin-coupon-index') }}" class=" wave-effect"><i class="fas fa-percentage"></i>{{ __('Set Coupons') }}</a> -->
    </li>
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

    <!-- <li>
        <a href="#msg" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-fw fa-newspaper"></i>{{ __('Messages') }}
        </a>
        <ul class="collapse list-unstyled" id="msg" data-parent="#accordion">
            <li>
                <a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a>
            </li>
            <li>
                <a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a>
            </li>
        </ul>
    </li> -->

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
            <li>
                <a href="{{ route('admin-shipping-index') }}"><span>{{ __('Shipping Methods') }}</span></a>
            </li>
            <!-- <li>
                <a href="{{ route('admin-package-index') }}"><span>{{ __('Packagings') }}</span></a>
            </li> -->
            <li>
                <a href="{{ route('admin-pick-index') }}"><span>{{ __('Local Pincode') }}</span></a>
            </li>
            <!-- <li>
                <a href="{{ route('admin-stock-management-index') }}"><span>{{ __('Tea Stock Management') }}</span></a>
            </li> -->
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
    <li>
        <a href="#emails" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-at"></i>{{ __('Email Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="emails" data-parent="#accordion">
            <li><a href="{{route('admin-mail-index')}}"><span>{{ __('Email Template') }}</span></a></li>
            <li><a href="{{route('admin-mail-config')}}"><span>{{ __('Email Configurations') }}</span></a></li>
            <!-- <li><a href="{{route('admin-group-show')}}"><span>{{ __('Group Email') }}</span></a></li> -->
        </ul>
    </li>
    <li>
        <a href="#payments" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-file-code"></i>{{ __('Payment Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="payments" data-parent="#accordion">
            <!-- <li><a href="{{route('admin-reward-index')}}"><span>{{__('Reward Information')}}</span></a></li> -->
            <li><a href="{{route('admin-gs-payments')}}"><span>{{__('Payment Information')}}</span></a></li>
            <li><a href="{{route('admin-payment-index')}}"><span>{{ __('Payment Gateways') }}</span></a></li>
            <!-- <li><a href="{{route('admin-currency-index')}}"><span>{{ __('Currencies') }}</span></a></li> -->
        </ul>
    </li>
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
    <!-- <li>
        <a href="#langs" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-language"></i>{{ __('Language Settings') }}
        </a>
        <ul class="collapse list-unstyled" id="langs" data-parent="#accordion">
                <li><a href="{{route('admin-lang-index')}}"><span>{{ __('Website Language') }}</span></a></li>
                <li><a href="{{route('admin-tlang-index')}}"><span>{{ __('Admin Panel Language') }}</span></a></li>

        </ul>
    </li> -->
    <li>
        <a href="#seoTools" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-wrench"></i>{{ __('SEO Tools') }}
        </a>
        <ul class="collapse list-unstyled" id="seoTools" data-parent="#accordion">
            <!-- <li>
                <a href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a>
            </li> -->
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
    <li>
        <a href="{{ route('admin-staff-index') }}" class=" wave-effect"><i class="fas fa-user-secret"></i>{{ __('Manage Staffs') }}</a>
    </li>

    <!-- <li>
        <a href="{{ route('admin-subs-index') }}" class=" wave-effect"><i class="fas fa-users-cog mr-2"></i>{{ __('Subscribers') }}</a>
    </li> -->

        <li>
            <a href="{{ route('admin-role-index') }}" class=" wave-effect"><i class="fas fa-user-tag"></i>{{ __('Manage Roles') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-cache-clear') }}" class=" wave-effect"><i class="fas fa-sync"></i>{{ __('Clear Cache') }}</a>
        </li>
        