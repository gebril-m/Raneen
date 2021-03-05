@extends('layouts.app')
@section('container')
<!-- breadcrumb start -->
<div class="breadcrumb-main mtpage">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>{{trans('cart.cart')}}</h2>
                        <ul>
                            <li><a href="#">{{trans('home.home')}}</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="#">{{trans('cart.cart')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End --> 
<section class="contact-page register-page section-big-py-space bg-light">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="mb-3">PERSONAL DETAIL</h3>
                <form class="theme-form" method="post" action="{{route('web.user.profile.update')}}">
                    @csrf
                    @if(session()->has('msg'))
                        <div class="alert alert-success">
                            {{ session()->get('msg') }}
                        </div>
                    @endif 
                    <div class="form-row">
                                
                    <div class="col-md-6">
                            <div class="form-group">
                                
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ (isset($user->details->first_name)) ? $user->details->first_name : '' }}">
                                @error('first_name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label>Last Name</label>
                                                <input type="text" name="last_name" class="form-control" value="{{isset($user->details->last_name) ? $user->details->last_name : ''}}">
                                                @error('last_name')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                                
                                <label for="email" class="float-none">Gender</label> <br>
                                <div class="card" style="border:1px solid #ced4da;border-radius:0;">
                                    <div class="card-body" style="padding:13px 25px;">
                                        <div style="display:inline-block;">
                                            <input type="radio" name="gender" value="m" {{ ($user->gender == 'm') ? 'checked' : ''}}> Male <br>
                                        </div>
                                        <div style="display:inline-block;">
                                            <input type="radio" name="gender" value="f" {{ ($user->gender == 'f') ? 'checked' : ''}}> Female
                                        </div>
                                    </div>
                                </div>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                            
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="dob">Date Of Birth</label> <br>
                                <input id="dob" type="date" class="form-control" name="dob" value="{{ $user->dob }}" autocomplete="dob">
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                            
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="contact_number">Contact Number</label> <br>
                                <input id="contact_number" type="number" class="form-control" name="contact_number" value="{{ $user->contact_number }}" autocomplete="contact_number">
                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror                            
                            </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label class="field-label">Order Phone</label>
                                <input type="number" name="phone" class="form-control" value="{{isset($user->details->phone) ? $user->details->phone : ''}}">
                                @error('phone')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label class="field-label">Order Email Address</label>
                                                <input type="text" name="email" class="form-control" value="{{isset($user->details->email) ? $user->details->email : ''}}">
                                                @error('email')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label class="field-label">Country</label>
                                                {{ Form::select('country_id', $countries, isset($user->details->country_id) ? $user->details->country_id : '', ['class'=>'form-control'])}}
                                                <!-- {{ Form::select('country_id', $countries)}} -->
                                                @error('country_id')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label class="field-label">Address</label>
                                                <input type="text" name="address" class="form-control" value="{{isset($user->details->address) ? $user->details->address : ''}}">
                                                @error('address')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label class="field-label">Town/City</label>
                                                {{ Form::select('city_id', $cities, isset($user->details->city_id) ? $user->details->city_id : '', ['class'=>'form-control'])}}
                                                <!-- {{ Form::select('city_id', $cities)}} -->
                                                @error('city_id')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
                                <label class="field-label">State / County</label>
                                                <input type="text" name="state" class="form-control" value="{{isset($user->details->state) ? $user->details->state : ''}}">
                                                @error('state')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                
<label class="field-label">Postal Code</label>
                                                <input type="number" name="postal_code" class="form-control" value="{{isset($user->details->postal_code) ? $user->details->postal_code : ''}}">
                                                @error('postal_code')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                               
                            </div>
                        </div>

                        
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="field-label">Password (Leave Empty To Keep Current)</label>
                                        <input type="password" name="password" class="form-control">
                                        @error('password')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="field-label">Password Confirm</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                        @error('password_confirmation')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>        
                            </div>
                        
                        <div class="col-md-12">
                        <br>
                            <button class="btn btn-sm btn-normal mb-lg-5" type="submit">Save setting</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
