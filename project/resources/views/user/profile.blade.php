@extends('layouts.front')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/front/css/user.css')}}">
@endsection
@section('content')

<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
<div class="col-lg-8">
                    <div class="user-profile-details">
                        <div class="account-info">
                            <div class="header-area">
                                <h4 class="title">
                                    {{__('Edit Profile') }}
                                </h4>
                                <p>Please fill this form to continue in the world of tea</p>
                            </div>
                            <div class="edit-info-area">

                                <div class="body">
                                    <div class="edit-info-area-form">
                                        <div class="gocover"
                                            style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                                        </div>
                                        <form id="userform" action="{{route('user-profile-update')}}" method="POST"
                                            enctype="multipart/form-data">

                                            {{ csrf_field() }}

                                            @include('includes.admin.form-both')
                                            <div class="upload-img">
                                                @if($user->is_provider == 1)
                                                <div class="img"><img
                                                        src="{{ $user->photo ? asset($user->photo):asset('assets/images/'.$gs->user_image) }}">
                                                </div>
                                                @else
                                                <div class="img"><img
                                                        src="{{ $user->photo ? asset('assets/images/users/'.$user->photo):asset('assets/images/'.$gs->user_image) }}">
                                                </div>
                                                @endif
                                                @if($user->is_provider != 1)
                                                <div class="file-upload-area">
                                                    <div class="upload-file">
                                                        <input type="file" name="photo" class="upload">
                                                        <span>{{ __('Upload') }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input name="name" type="text" class="input-field"
                                                        placeholder="{{ __('User Name') }}" required=""
                                                        value="{{ $user->name }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <input name="phone" type="text" class="input-field"
                                                        placeholder="{{ __('Phone Number') }}" required=""
                                                        value="{{ $user->phone }}" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input name="email" type="email" class="input-field"
                                                        placeholder="{{ __('Email Address') }}" required=""
                                                        value="{{ $user->email }}" >
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <input name="city" type="text" class="input-field"
                                                        placeholder="{{ __('City') }}" value="{{ $user->city }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input name="family_member" type="number" class="input-field"
                                                        placeholder="{{ __('Total Family Member') }}" required=""
                                                        value="{{ $user->family_member }}" >
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <input name="currently_using_tea_brand" type="text" class="input-field"
                                                        placeholder="{{ __('Currently Using Tea Brand') }}" value="{{ $user->currently_using_tea_brand }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input name="monthly_consuming_tea_weight" type="text" class="input-field"
                                                        placeholder="{{ __('Monthly Consuming Tea Weight') }}" required=""
                                                        value="{{ $user->monthly_consuming_tea_weight }}" >
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <input name="monthly_tea_cost" type="number" class="input-field"
                                                        placeholder="{{ __('Monthly Tea Cost') }}" value="{{ $user->monthly_tea_cost }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                

                                                <div class="col-lg-6">
                                                    <select class="input-field" name="tea_type" >
                                                        <option value="">{{ __('Select Tea Type') }}</option>
                                                        <option value="Leaf Tea"  {{ $user->tea_type == 'Leaf Tea' ? 'selected' : '' }}>Leaf Tea</option>
												        <option value="CTC Tea"  {{ $user->tea_type == 'CTC Tea' ? 'selected' : '' }}>CTC Tea</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="input-field" name="preferred_time_to_receive_call_from_our_tea_expert" >
                                                        <option value="">{{ __('Select Preferred Time To Receive Call From Our Tea Expert') }}</option>
                                                        <option value="10:00 am - 12:00 pm"  {{ $user->preferred_time_to_receive_call_from_our_tea_expert == '10:00 am - 12:00 pm' ? 'selected' : '' }}>10:00 am - 12:00 pm</option>
                                                        <option value="12:00 pm - 2:00 pm"  {{ $user->preferred_time_to_receive_call_from_our_tea_expert == '12:00 pm - 2:00 pm' ? 'selected' : '' }}>12:00 pm - 2:00 pm</option>
                                                        <option value="2:00 pm - 4:00 pm"  {{ $user->preferred_time_to_receive_call_from_our_tea_expert == '2:00 pm - 4:00 pm' ? 'selected' : '' }}>2:00 pm - 4:00 pm</option>
                                                        <option value="4:00 pm - 6:00 pm"  {{ $user->preferred_time_to_receive_call_from_our_tea_expert == '4:00 pm - 6:00 pm' ? 'selected' : '' }}>4:00 pm - 6:00 pm</option>
                                                        <option value="6:00 pm - 8:00 pm"  {{ $user->preferred_time_to_receive_call_from_our_tea_expert == '6:00 pm - 8:00 pm' ? 'selected' : '' }}>6:00 pm - 8:00 pm</option>
                                                        <option value="8:00 pm - 10:00 pm"  {{ $user->preferred_time_to_receive_call_from_our_tea_expert == '8:00 pm - 10:00 pm' ? 'selected' : '' }}>8:00 pm - 10:00 pm</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <textarea class="input-field" name="address" required=""
                                                        placeholder="{{ __('Address') }}">{{ $user->address }}</textarea>
                                                </div>

                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-lg-6">
                                                    <input name="city" type="text" class="input-field"
                                                        placeholder="{{ __('City') }}" value="{{ $user->city }}">
                                                </div>

                                                <div class="col-lg-6">
                                                    <select class="input-field" name="country" id="change_country" >
                                                        <option value="">{{ __('Select Country') }}</option>
                                                        @foreach (App\Models\Country::where('status',1)->get() as $data)
                                                            <option value="{{ $data->country_name }}" data-href="{{route('select.country.state',[$data->id,$user->id])}}" {{ $user->country == $data->country_name ? 'selected' : '' }}>
                                                                {{ $data->country_name }}
                                                            </option>
                                                         @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <select class="input-field" name="state" id="set_state">
                                                    </select>
                                                </div>

                                            </div> -->
                                            
                                            <!-- <div class="row">
                                                <div class="col-lg-6">
                                                    <select class="input-field" name="state" id="set_state">
                                                    </select>
                                                </div>
                                                    <div class="col-lg-6">
                                                            <input name="zip" type="text" class="input-field"
                                                                placeholder="{{ __('Zip') }}" value="{{ $user->zip }}">
                                                    </div>
                                            </div> -->


                                            <!-- <div class="row">
                                                
                                            </div> -->

                                            <div class="form-links">
                                                <button class="submit-btn" type="submit">{{ __('Save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </div>
  </section>

@endsection
