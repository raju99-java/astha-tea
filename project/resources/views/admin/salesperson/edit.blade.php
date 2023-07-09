@extends('layouts.load')
@section('content')

						<div class="content-area">
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">
                        					@include('includes.admin.form-error') 
											<form id="geniusformdata" action="{{ route('admin-salesperson-edit',$data->id) }}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                                <h4 class="heading">{{ __("Sales Person Profile Image") }} *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <div class="img-upload">
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset('assets/images/salesperson/'.$data->photo):asset('assets/images/noimage.png') }});">
						                               
						                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __("Upload Image") }}</label>
						                                    <input type="file" name="photo" class="img-upload" id="image-upload">
						                                
						                                  </div>
						                                  <p class="text">{{ __("Prefered Size: (600x600) or Square Sized Image") }}</p>
						                            </div>
						                          </div>
						                        </div>
												


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">{{ __('Full Name') }}* </h4>
															<p class="sub-heading">{{ __('(In Any Language)') }}</p>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" placeholder="{{ __('Enter Full Name') }}"
															name="name" value="{{ $data->name }}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">{{ __('Email') }}*</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input name="email" type="email" class="input-field"
															placeholder="{{ __('Enter Email') }}" value="{{ $data->email }}">
														
													</div>
												</div>
					
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">{{ __('Phone Number') }}*</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input name="phone" type="tel" class="input-field"
															placeholder="{{ __('Enter Phone Number') }}" value="{{ $data->phone }}">
														
													</div>
												</div>
												<div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                                <h4 class="heading">{{ __("GOVT. Id Proof") }} *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <div class="img-upload">
						                                <div id="image-preview" class="img-preview" style="background: url({{ $data->govt_id_proof ? asset('assets/images/salesperson/'.$data->govt_id_proof):asset('assets/images/noimage.png') }});">
						                               
						                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __("Upload Image") }}</label>
						                                    <input type="file" name="govt_id_proof" class="img-upload" id="govt-id-proof-upload">
						                                
						                                  </div>
						                                  <p class="text">{{ __("Prefered Size: (600x600) or Square Sized Image") }}</p>
						                            </div>
						                          </div>
						                        </div>
												
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">
																{{ __('Address') }} *
															</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<div class="text-editor">
															<textarea name="address" class="input-field"
																placeholder="{{ __('Enter Address') }}">{{ $data->address }}</textarea>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">{{ __('Password') }}*</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input name="password" type="password" class="input-field"
															placeholder="{{ __('Enter Password') }}" value="">
														
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading">{{ __('Wallet Commision') }}*</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input name="commission" type="number" class="input-field"
															placeholder="{{ __('Total Commission') }}" value="{{ $data->commission }}">
														
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