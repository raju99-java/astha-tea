@extends('layouts.front')
@section('styles')
    	<!-- <link rel="stylesheet" href="{{asset('assets/front/css/contact.css')}}"> -->
@endsection

@section('content')

<!-- Breadcrumb Area Start -->
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb-title-div">
                    <div class="bread-left-side">
                        <h2>About Us</h2>
                    </div>
                    <div class="breadcrumb-ul right-side">
                        <ul>
                        <li>
                        <a href="{{ route('front.index') }}">
                            {{ __('Home/') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.about') }}">
                            {{ __('About Us') }}
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
<section class="about-us">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 intro_image">
                <img class="w-100" src="assets/front/images/people1.webp">
            </div>
            <div class="col-md-6 intro_detail d-flex align-items-center">
                <div class="info-intro">
                    <h3 class="title_intro">ABOUT US</h3>
                    <p class="content_intro">As masters of tea since the late 1990s, the Astha Tea is heralded for our iconic gardens and authentic tea making process. We have perfected the art and traditions of tea manufacturing while embracing science and modern technologies to maintain international standards in tea production and sustainability.</p>
                    <p class="content_intro">As Astha Tea Family, we aim to deliver high-quality, sustainable, and innovative products, that will delight consumers. The best ingredients, the best practices, the best technology—experience the journey that brings you the perfect cup of tea, every time.</p>
                </div>
            </div>
        </div>
    </div>
</section> 

<div class="about-servicebox" style="background-image: url(assets/front/images/image-10.webp)">
    <div class="container container-v2">
        <h2 class="title-servicebox">Reasons to shop with us</h2>
        <div class="row">
            <div class="col-sm-4 col-md-4">
                <div class="box-service">
                    <h4 class="titles">24/7 FRIENDLY SUPPORT</h4>
                    <p class="contents">Our support team always ready for you to 7 days a week.</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="box-service">
                    <h4 class="titles">7 DAYS EASY RETURN</h4>
                    <p class="contents">Product any fault within 7 days for an immediately exchange.</p>
                </div>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="box-service">
                    <h4 class="titles">QUALITY GUARANTEED</h4>
                    <p class="contents">If your product aren't perfect, return them for a full refund.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
