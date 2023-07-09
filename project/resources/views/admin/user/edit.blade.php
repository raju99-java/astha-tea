@extends('layouts.load')
@section('content')

						<div class="content-area">
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">
                        					@include('includes.admin.form-error') 
											<form id="geniusformdata" action="{{ route('admin-user-edit',$data->id) }}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                                <h4 class="heading">{{ __("Customer Profile Image") }} *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <div class="img-upload">
						                            	@if($data->is_provider == 1)
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset($data->photo):asset('assets/images/noimage.png') }});">
						                            	@else
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset('assets/images/users/'.$data->photo):asset('assets/images/noimage.png') }});">
						                                @endif
						                                @if($data->is_provider != 1)
						                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __("Upload Image") }}</label>
						                                    <input type="file" name="photo" class="img-upload" id="image-upload">
						                                @endif
						                                  </div>
						                                  <p class="text">{{ __("Prefered Size: (600x600) or Square Sized Image") }}</p>
						                            </div>
						                          </div>
						                        </div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Name") }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="name" placeholder="{{ __("User Name") }}" required="" value="{{ $data->name }}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Email") }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="email" placeholder="{{ __("Email Address") }}" value="{{ $data->email }}" disabled="">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Phone") }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="phone" placeholder="{{ __("Phone Number") }}" required="" value="{{ $data->phone }}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Address") }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="address" placeholder="{{ __("Address") }}" required="" value="{{ $data->address }}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("City") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="phone" placeholder="{{ __("City") }}" value="{{ $data->phone }}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Total Family member") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="family_member" placeholder="{{ __("Total Family member") }}" value="{{ $data->family_member }}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Currently using tea brand") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="currently_using_tea_brand" placeholder="{{ __("Currently using tea brand") }}" value="{{ $data->currently_using_tea_brand }}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Monthly consuming tea weight") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="monthly_consuming_tea_weight" placeholder="{{ __("Monthly consuming tea weight") }}" value="{{ $data->monthly_consuming_tea_weight }}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Monthly tea cost") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="monthly_tea_cost" placeholder="{{ __("Monthly tea cost") }}" value="{{ $data->monthly_tea_cost }}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">{{ __('Tea Type') }}* </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select name="tea_type" required="">
															<option value="">Select Tea Type</option>
															<option value="Leaf Tea" {{$data->tea_type == 'Leaf Tea' ? 'selected':''}}>Leaf Tea</option>
															<option value="CTC Tea" {{$data->tea_type == 'CTC Tea' ? 'selected':''}}>CTC Tea</option>
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">{{ __('Preferred Time To Receive Call From Our Tea Expert') }}* </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select required="" name="preferred_time_to_receive_call_from_our_tea_expert" >
															<option value="">{{ __('Select Preferred Time To Receive Call From Our Tea Expert') }}</option>
															<option value="10:00 am - 12:00 pm"  {{ $data->preferred_time_to_receive_call_from_our_tea_expert == '10:00 am - 12:00 pm' ? 'selected' : '' }}>10:00 am - 12:00 pm</option>
															<option value="12:00 pm - 2:00 pm"  {{ $data->preferred_time_to_receive_call_from_our_tea_expert == '12:00 pm - 2:00 pm' ? 'selected' : '' }}>12:00 pm - 2:00 pm</option>
															<option value="2:00 pm - 4:00 pm"  {{ $data->preferred_time_to_receive_call_from_our_tea_expert == '2:00 pm - 4:00 pm' ? 'selected' : '' }}>2:00 pm - 4:00 pm</option>
															<option value="4:00 pm - 6:00 pm"  {{ $data->preferred_time_to_receive_call_from_our_tea_expert == '4:00 pm - 6:00 pm' ? 'selected' : '' }}>4:00 pm - 6:00 pm</option>
															<option value="6:00 pm - 8:00 pm"  {{ $data->preferred_time_to_receive_call_from_our_tea_expert == '6:00 pm - 8:00 pm' ? 'selected' : '' }}>6:00 pm - 8:00 pm</option>
															<option value="8:00 pm - 10:00 pm"  {{ $data->preferred_time_to_receive_call_from_our_tea_expert == '8:00 pm - 10:00 pm' ? 'selected' : '' }}>8:00 pm - 10:00 pm</option>
														</select>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("User type") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select id="type" name="user_type" required="">
															<option value="">{{ __('Select User Type') }}</option>
															<option value="commercial" {{$data->user_type == 'commercial' ? 'selected':''}}>{{ __('commercial') }}</option>
															<option value="domemestic" {{$data->user_type == 'domemestic' ? 'selected':''}}>{{ __('domemestic') }}</option>
															
														</select>
														
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Postal Code") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="zip" placeholder="{{ __("Postal Code") }}" value="{{ $data->zip }}">
													</div>
												</div>

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit">{{ __("Save") }}</button>
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