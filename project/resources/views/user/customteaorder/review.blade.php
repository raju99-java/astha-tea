@extends('layouts.load')
@section('content')

						<div class="content-area">
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">
                        					@include('includes.admin.form-login')
											<form id="customteareviewform" action="{{route('user-customtea-review-submit')}}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}
												<input type="hidden" id="rating" name="rating" value="5">
												<input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
												<input type="hidden" name="order_id" value="{{$data->id}}">
						                        <div class="row">
													<div class="col-lg-12">
														<div class="review-area"> 
															<div class="star-area"> 
																<ul class="star-list"> 
																	<li class="stars active" data-val="1"> <i class="fas fa-star"></i></li> 
																	<li class="stars" data-val="2"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> </li> 
																	<li class="stars" data-val="3"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> </li> 
																	<li class="stars" data-val="4"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> </li> 
																	<li class="stars" data-val="5"> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> </li> 
																</ul> 
															</div> 
														</div>
													</div>
											    </div>
												
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group q-grp">
															<label class="review-label" for="reviewComments">Comments</label>
															<textarea name="comment" rows="3" class="form-control review-text" placeholder="Please type your comment here" required></textarea>	<span class="help-block"></span>
														</div>
													</div>
												</div>



						                        <div class="row">
						                          <div class="col-lg-12 text-center">
						                            <button class="addProductSubmit-btn" type="submit">{{ __("Submit") }}</button>
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