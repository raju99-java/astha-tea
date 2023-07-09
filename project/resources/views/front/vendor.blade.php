@extends('layouts.front')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/front/css/category.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/range.css')}}">
@endsection
@section('content')

<!-- Vendor Area Start -->
<div class="vendor-banner" style="background: url({{  $vendor->shop_image != null ? asset('assets/images/vendorbanner/'.$vendor->shop_image) : '' }}); background-repeat: no-repeat; background-size: cover;background-position: center;{!! $vendor->shop_image != null ? '' : 'background-color:'.$gs->vendor_color !!} ">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="content">
          <p class="sub-title">
              {{ __('Store Name') }}
          </p>
          <h2 class="title">
            {{ $vendor->shop_name }}
          </h2>
        </div>
      </div>
    </div>
  </div>
</div>


@if(count($sliders))
    <div class="vendor-area-slider">
        <div class="slide-progress"></div>
        <div class="intro-carousel">
            @foreach($sliders as $data)
                <div class="intro-content {{$data->position}} lazy" style="background: url({{asset('assets/images/sliders/'.$data->photo)}})">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="slider-content">
                                    <!-- layer 1 -->
                                    <div class="layer-1">
                                        <h4 style="font-size: {{$data->subtitle_size}}px; color: {{$data->subtitle_color}}" class="subtitle subtitle{{$data->id}}" data-animation="animated {{$data->subtitle_anime}}">{{$data->subtitle_text}}</h4>
                                        <h2 style="font-size: {{$data->title_size}}px; color: {{$data->title_color}}" class="title title{{$data->id}}" data-animation="animated {{$data->title_anime}}">{{$data->title_text}}</h2>
                                    </div>
                                    <!-- layer 2 -->
                                    <div class="layer-2">
                                        <p style="font-size: {{$data->details_size}}px; color: {{$data->details_color}}"  class="text text{{$data->id}}" data-animation="animated {{$data->details_anime}}">{{$data->details_text}}</p>
                                    </div>
                                    <!-- layer 3 -->
                                    <div class="layer-3">
                                        <a href="{{$data->link}}" target="_blank" class="mybtn1"><span>{{ __('Shop Now') }} <i class="fas fa-chevron-right"></i></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif



{{-- Info Area Start --}}
<section class="info-area">
  <div class="container">


        @foreach($services->chunk(4) as $chunk)

        <div class="row">

        <div class="col-lg-12 p-0">
          <div class="info-big-box">
              <div class="row">
                @foreach($chunk as $service)
              <div class="col-6 col-xl-3 p-0">
                <div class="info-box">
                  <div class="icon">
                    <img src="{{ asset('assets/images/services/'.$service->photo) }}">
                  </div>
                  <div class="info">
                      <div class="details">
                        <h4 class="title">{{ $service->title }}</h4>
                      <p class="text">
                        {!! $service->details !!}
                      </p>
                      </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
          </div>
        </div>

        </div>

          @endforeach


        </div>
</section>
{{-- Info Area End  --}}




<!-- SubCategori Area Start -->
  <section class="sub-categori">
    <div class="container">
      <div class="row">

        @include('includes.vendor-catalog')

        <div class="col-lg-9 order-first order-lg-last">
          <div class="right-area">

            @if(count($vprods) > 0)

              @include('includes.vendor-filter')

            <div class="categori-item-area">
              <div class="row">
                @foreach($vprods as $prod)
                  @include('includes.product.product')
                @endforeach
              </div>

              <div class="page-center category">
                {!! $vprods->appends(['sort' => request()->input('sort'), 'min' => request()->input('min'), 'max' => request()->input('max')])->links() !!}
              </div>
            </div>

            @else
              <div class="page-center">
                <h4 class="text-center">{{__('No Product Found.') }}</h4>
              </div>
            @endif


          </div>
        </div>
      </div>
    </div>
  </section>
<!-- SubCategori Area End -->


@if(Auth::guard('web')->check())

{{-- MESSAGE VENDOR MODAL --}}

<div class="message-modal">
  <div class="modal" id="vendorform1" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel1">{{ __('Send Message') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <div class="container-fluid p-0">
          <div class="row">
            <div class="col-md-12">
              <div class="contact-form">

                <form id="emailreply">
                  {{csrf_field()}}
                  <ul>

                    <li>
                      <input type="text" class="input-field" readonly="" placeholder="Send To {{ $vendor->shop_name }}" readonly="">
                    </li>

                    <li>
                      <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject *')}}" required="">
                    </li>

                    <li>
                      <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }}" required=""></textarea>
                    </li>

                    <input type="hidden" name="email" value="{{ Auth::guard('web')->user()->email }}">
                    <input type="hidden" name="name" value="{{ Auth::guard('web')->user()->name }}">
                    <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                    <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">

                  </ul>
                  <button class="submit-btn" id="emlsub1" type="submit">{{ __('Send Message') }}</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>

{{-- MESSAGE VENDOR MODAL ENDS --}}


@endif

@endsection

@section('scripts')

<script type="text/javascript">
  lazy();
  $(function () {
    $("#slider-range").slider({
    range: true,
    orientation: "horizontal",
    min: 0,
    max: 10000000,
    values: [{{ isset($_GET['min']) ? $_GET['min'] : '0' }}, {{ isset($_GET['max']) ? $_GET['max'] : '10000000' }}],
    step: 5,

    slide: function (event, ui) {
      if (ui.values[0] == ui.values[1]) {
        return false;
      }

      $("#min_price").val(ui.values[0]);
      $("#max_price").val(ui.values[1]);
    }
    });

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));

  });
</script>

<script type="text/javascript">
          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
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
                'subject'   : subject,
                'message'  : message,
                'email'   : email,
                'name'  : name,
                'user_id'   : user_id,
                'vendor_id'  : vendor_id
                  },
            success: function() {
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
