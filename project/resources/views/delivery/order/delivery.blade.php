@extends('layouts.load')




@section('content')

            <div class="content-area">

              <div class="add-product-content">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area" id="modalEdit">
                        @include('includes.delivery.form-error')  
                      <form id="geniusformdata" action="{{route('delivery-order-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}



                        



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Delivery Status') }} *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select name="status" required="">
                                <option value="processing" {{ $data->status == "processing" ? "selected":"" }}>{{ __('Processing') }}</option>
                                <option value="delivered" {{ $data->status == "delivered" ? "selected":"" }}>{{ __('Delivered') }}</option>
                                
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

