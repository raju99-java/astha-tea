@extends('layouts.admin')

@section('styles')

<style type="text/css">
    .table-responsive {
    overflow-x: hidden;
}
table#example2 {
    margin-left: 10px;
}

</style>

@endsection

@section('content')

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __("Sales Person Details") }} <a class="add-btn" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> {{ __("Back") }}</a></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-salesperson-index') }}">{{ __("Sales Person") }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-salesperson-show',$data->id) }}">{{ __("Details") }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                            <div class="add-product-content1 customar-details-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="user-image">
                                                            
                                                            <img src="{{ $data->photo ? asset('assets/images/salesperson/'.$data->photo):asset('assets/images/'.$gs->user_image)}}" alt="No Image">                                            
                                                            
                                                            <a href="javascript:;" class="mybtn1 send" data-email="{{ $data->email }}" data-toggle="modal" data-target="#vendorform">{{ __("Send Message") }}</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th>{{ __("ID#") }}</th>
                                                            <td>{{$data->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Name") }}</th>
                                                            <td>{{$data->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Email") }}</th>
                                                            <td>{{$data->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Phone") }}</th>
                                                            <td>{{$data->phone}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Address") }}</th>
                                                            <td>{{$data->address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("GOVT. Id Proof") }}</th>
                                                            <td> <a class="mybtn1" href="{{asset('assets/images/salesperson/'.$data->govt_id_proof)}}" target="_blank">click here to view</a></td>
                                                        </tr>
                                                        

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">    
                                                            <tr>
                                                                <th>{{ __("Joined") }}</th>
                                                                <td>{{$data->created_at->diffForHumans()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __("Wallet Commision") }}</th>
                                                                <td>{{$data->commission}}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __("Send Message") }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form id="emailreply1">
                                    {{csrf_field()}}
                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml1" name="to" placeholder="{{ __("Email") }} *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj1" name="subject" placeholder="{{ __("Subject") }} *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg1" placeholder="{{ __("Your Message") }} *" required=""></textarea>
                                        </li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub1" type="submit">{{ __("Send Message") }}</button>
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

{{-- MESSAGE MODAL ENDS --}}

@endsection

@section('scripts')



@endsection