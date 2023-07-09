@extends('layouts.vendor')

@section('content')

<div class="content-area">
            <div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Social Links') }}</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('vendor-dashboard') }}">{{ __('Dashbord') }} </a>
                      </li>
                      <li>
                        <a href="javascript:;">{{ __('Settings') }}</a>
                      </li>
                      <li>
                        <a href="{{ route('vendor-social-index') }}">{{ __('Social Links') }}</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="add-product-content1">
              <div class="product-description">
              <div class="body-area">
            <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
              <form id="geniusform" class="form-horizontal" action="{{ route('vendor-social-update') }}" method="POST">
              {{ csrf_field() }}

              @include('includes.admin.form-both')

                <div class="row">
                  <label class="control-label col-sm-3" for="facebook">{{ __('Facebook') }} *</label>
                  <div class="col-sm-6">
                    <input class="form-control" name="f_url" id="facebook" placeholder="{{ __('Facebook') }}"  type="text" value="{{$data->f_url}}">
                  </div>
                  <div class="col-sm-3">
                    <label class="switch">
                      <input type="checkbox" name="f_check" value="1" {{$data->f_check==1?"checked":""}}>
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>

                <div class="row">
                  <label class="control-label col-sm-3" for="gplus">{{ __('Google Plus') }} *</label>
                  <div class="col-sm-6">
                    <input class="form-control" name="g_url" id="gplus" placeholder="{{ __('Google Plus') }}"  type="text" value="{{$data->g_url}}">
                  </div>
                  <div class="col-sm-3">
                    <label class="switch">
                      <input type="checkbox" name="g_check" value="1" {{$data->g_check==1?"checked":""}}>
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>

                <div class="row">
                  <label class="control-label col-sm-3" for="twitter">{{ __('Twitter') }} *</label>
                  <div class="col-sm-6">
                    <input class="form-control" name="t_url" id="twitter" placeholder="{{ __('Twitter') }}"  type="text" value="{{$data->t_url}}">
                  </div>
                  <div class="col-sm-3">
                    <label class="switch">
                      <input type="checkbox" name="t_check" value="1" {{$data->t_check==1?"checked":""}}>
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>

                <div class="row">
                  <label class="control-label col-sm-3" for="linkedin">{{ __('Linkedin') }} *</label>
                  <div class="col-sm-6">
                    <input class="form-control" name="l_url" id="linkedin" placeholder="{{ __('Linkedin') }}"  type="text" value="{{$data->l_url}}">
                  </div>
                  <div class="col-sm-3">
                    <label class="switch">
                      <input type="checkbox" name="l_check" value="1" {{$data->l_check==1?"checked":""}}>
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>


                <div class="row justify-content-center">
                  <div class="col-lg-3">
                    <div class="left-area">

                    </div>
                  </div>
                  <div class="col-lg-6">
                    <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                  </div>
                </div>


              </form>
              </div>
            </div>
          </div>

@endsection
