@extends('layouts.front')
@section('content')

<!-- Breadcrumb Area Start -->

<section class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="breadcrumb-title-div">
          <div class="bread-left-side">
            <h2>{{ $page->title }}</h2>
          </div>
          <div class="breadcrumb-ul right-side">
            <ul>
              <li>
                <a href="{{route('front.index')}}">HOME</a>/
              </li>
              <li>
                <a href="{{ route('front.page',$page->slug) }}">
                  {{ $page->title }}
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



<section class="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="about-info">
            <!-- <h4 class="title">
              {{ $page->title }}
            </h4> -->
            <p>
              {!! $page->details !!}
            </p>

          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
