@extends('layouts.front')
@section('styles')
    	<link rel="stylesheet" href="{{asset('assets/front/css/contact.css')}}">
@endsection

@section('content')

<!-- Breadcrumb Area Start -->
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-title-div">
                    <div class="bread-left-side">
                        <h2>Contact Us</h2>
                    </div>
                    <div class="breadcrumb-ul right-side">
                        <ul>
                        <li>
                        <a href="{{ route('front.index') }}">
                            {{ __('Home/') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.contact') }}">
                            {{ __('Contact Us') }}
                        </a>
                    </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb Area End -->
<div class="total-content" id="content">
    <!-------------------------------------------------map------------------------------->
    <!--<section class="maps">-->
    <!--    <div class="container">-->
    <!--        <div class="col-sm-12 m-0 p-0">-->
    <!--            <div class="map-sec">-->
    <!--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d471218.38559717475!2d88.04952484283037!3d22.676385756918386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1650981025786!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->

    
    <!-----------------------------------------------//map------------------------------->
</div>

    <!-- Contact Us Area Start -->
    <section class="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-section-title">
                        <h5>{!! $ps->contact_title !!}</h5>
                        <p>{!! $ps->contact_text !!}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-xl-7 col-lg-7 col-md-6">
                    <div class="left-area">
                        <div class="contact-form">
                            <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                            <form id="contactform" action="{{route('front.contact.submit')}}" method="POST">
                                {{csrf_field()}}
                                    @include('includes.admin.form-both')

                                    <div class="form-input">
                                        <input type="text" name="name" placeholder="{{ __('Name') }} *" required="">
                                        <i class="icofont-user-alt-5"></i>
                                    </div>
                                    <div class="form-input">
                                            <input type="text" name="phone"  placeholder="{{ __('Phone Number') }} *">
																						<i class="icofont-ui-call"></i>
                                    </div>
                                    <div class="form-input">
                                            <input type="email" name="email"  placeholder="{{ __('Email Address') }} *" required="">
											<i class="icofont-envelope"></i>
                                    </div>
                                    <div class="form-input">
                                            <textarea name="text" placeholder="{{ __('Your Message') }} *" required=""></textarea>
                                    </div>

                                   


                                    <input type="hidden" name="to" value="{{ $ps->contact_email }}">
                                    <button class="submit-btn" type="submit">{{ __('Send Message') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-6">
                    <div class="right-area">

                        @if($ps->site != null || $ps->email != null )
                        <div class="contact-info ">
                            <div class="left ">
                                    <div class="icon">
                                            <i class="icofont-email"></i>
                                    </div>
                            </div>
                            <div class="content d-flex align-self-center">
                                <div class="content">
                                        @if($ps->site != null && $ps->email != null)
                                        <!-- <a href="{{$ps->site}}" target="_blank">{{$ps->site}}</a> -->
                                        <a href="mailto:{{$ps->email}}">{{$ps->email}}</a>
                                        @elseif($ps->site != null)
                                        <!-- <a href="{{$ps->site}}" target="_blank">{{$ps->site}}</a> -->
                                        @else
                                        <a href="mailto:{{$ps->email}}">{{$ps->email}}</a>
                                        @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($ps->street != null)
                        <div class="contact-info">
                                <div class="left">
                                        <div class="icon">
                                                <i class="icofont-google-map"></i>
                                        </div>
                                </div>
                                <div class="content d-flex align-self-center">
                                    <div class="content">
                                            <p>
                                                @if($ps->street != null)
                                                    {!! $ps->street !!}
                                                @endif
                                            </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($ps->phone != null || $ps->fax != null )
                            <div class="contact-info">
                                    <div class="left">
                                            <div class="icon">
                                                    <i class="icofont-smart-phone"></i>
                                            </div>
                                    </div>
                                    <div class="content d-flex align-self-center">
                                        <div class="content">
                                            @if($ps->phone != null && $ps->fax != null)
                                            <a href="tel:{{$ps->phone}}">{{$ps->phone}}</a>
                                            <!-- <a href="tel:{{$ps->fax}}">{{$ps->fax}}</a> -->
                                            @elseif($ps->phone != null)
                                            <a href="tel:{{$ps->phone}}">{{$ps->phone}}</a>
                                            @else
                                            <!-- <a href="tel:{{$ps->fax}}">{{$ps->fax}}</a> -->
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        @endif


                                <div class="social-links">
                                    <h4 class="title">{{ __('Find Us Here') }} :</h4>
                                    <ul>

                                     @if(App\Models\Socialsetting::find(1)->f_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->facebook }}" class="facebook" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->g_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->gplus }}" class="google-plus" target="_blank">
                                            <i class="fab fa-google-plus-g"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->t_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->twitter }}" class="twitter" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->l_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->linkedin }}" class="linkedin" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                      </li>
                                      @endif

                                      @if(App\Models\Socialsetting::find(1)->d_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->dribble }}" class="dribbble" target="_blank">
                                            <i class="fab fa-dribbble"></i>
                                        </a>
                                      </li>
                                      @endif
                                      
                                      @if(App\Models\Socialsetting::find(1)->i_status == 1)
                                      <li>
                                        <a href="{{ App\Models\Socialsetting::find(1)->instagram }}" class="dribbble" target="_blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                      </li>
                                      @endif

                                    </ul>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Us Area End-->

@endsection
