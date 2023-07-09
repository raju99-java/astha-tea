@extends('layouts.load')




@section('content')

            <div class="content-area">

              <div class="add-product-content">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area" id="modalEdit">
                        @include('includes.admin.form-error')  
                      <form id="geniusformdata" action="{{route('admin-customtea-order-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Payment Status') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="payment_status" required="">
                                <option value="Pending" {{$data->payment_status == 'Pending' ? "selected":""}}>{{ __('Unpaid') }}</option>
                                <option value="Completed" {{$data->payment_status == 'Completed' ? "selected":""}}>{{ __('Paid') }}</option>
                              </select>
                          </div>
                        </div>



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Delivery Status') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="status" required="">
                                <option value="pending" {{ $data->status == "pending" ? "selected":"" }}>{{ __('Pending') }}</option>
                                <option value="processing" {{ $data->status == "processing" ? "selected":"" }}>{{ __('Processing') }}</option>
                                <!-- <option value="on delivery" {{ $data->status == "on delivery" ? "selected":"" }}>{{ __('On Delivery') }}</option> -->
                                <option value="delivered" {{ $data->status == "delivered" ? "selected":"" }}>{{ __('Delivered') }}</option>
                                <option value="completed" {{ $data->status == "completed" ? "selected":"" }}>{{ __('Completed') }}</option>
                                <option value="declined" {{ $data->status == "declined" ? "selected":"" }}>{{ __('Declined') }}</option>
                              </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Deliver By') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="deliver_by" required="">
                                <option value="">{{_('Select the delivery person/method')}}</option>
                                <option value="0" {{ $data->deliver_by == '0' ? "selected":"" }}>{{_('None')}}</option>
                                @foreach($delivery as $dv)
                                <option value="{{$dv->id}}" {{ $data->deliver_by == $dv->id ? "selected":"" }}>{{$dv->name}}</option>
                                @endforeach
                              </select>
                          </div>
                        </div>



                        



                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection

@section('scripts')





@endsection

