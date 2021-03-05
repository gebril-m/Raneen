@extends('website.layouts.master')

@section('title',__('User.User Profile'))

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')

<main id="mainContent" class="main-content">
    <!-- Page Container -->
    <div class="page-container ptb-60">
        <div class="container">
            <div class="row row-rl-10 row-tb-20">
            @include('website.users.sidebar')

             
                <div class="page-content col-xs-12 col-sm-8 col-md-9">

                    <!-- Checkout Area -->
                    <section class="section checkout-area panel prl-30 pt-20 pb-40">
                        <h2 class="h2 mb-20 h-title">{{__('User.Account Information')}}</h2>
                        <form class="theme-form mb-30" method="post" action="{{route('web.user.profile.update')}}">
                            @csrf
                            @if(session()->has('msg'))
                                <div class="alert alert-success">
                                    {{ session()->get('msg') }}
                                </div>
                            @endif 
                            @if(session()->has('message') && session()->has('message') == 'state_change')
                                <div class="alert alert-warning">
                                    {{ __('User.change state and address to get access to checkout') }}
                                </div>
                            @endif 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('User.First Name')}}</label>
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
                                        <label>{{__('User.Last Name')}}</label>
                                        <input type="text" name="last_name" class="form-control" value="{{isset($user->details->last_name) ? $user->details->last_name : ''}}">
                                        @error('last_name')
                                        <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="float-none">{{__('User.Gender')}}</label> <br>
                                    <div class="card" style="border:1px solid #979797 ;border-radius:0; background-color:#fff; height:40px ;padding:8px 12px">
                                        <div class="card-body">
                                            <div style="display:inline-block;">
                                                <input type="radio" name="gender" value="m" {{ ($user->gender == 'm') ? 'checked' : ''}}> {{__('User.Male')}} <br>
                                            </div>
                                            <div style="display:inline-block;">
                                                <input type="radio" name="gender" value="f" {{ ($user->gender == 'f') ? 'checked' : ''}}> {{__('User.Female')}}
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
                                    <label for="dob">{{__('User.Date Of Birth')}}</label> <br>
                                    <input id="dob" type="date" class="form-control" name="dob" value="{{ $user->dob }}" autocomplete="dob">
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror   
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_number">{{__('User.Contact Number')}}</label> <br>
                                        <input id="contact_number" type="number" class="form-control" name="contact_number" value="{{ $user->contact_number }}" autocomplete="contact_number">
                                        @error('contact_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="field-label">{{__('User.Order Phone')}}</label>
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
                                        <label class="field-label">{{__('User.Order Email Address')}}</label>
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
                                        <label class="field-label">{{__('User.Country')}}</label>
                                        <select name="country_id" id="country_id" class="form-control">
                                            <option value="">- {{__('User.Country')}} -</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" @if(isset($user->details->country_id) && $user->details->country_id == $country->id) selected @endif >{{$country->name}}</option>
                                        @endforeach
                                        </select>
                                        @error('country_id')
                                        <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="field-label">{{__('Home.Address')}}</label>
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
                                        <label class="field-label">{{__('User.Town/City')}}</label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="">- {{__('User.Town/City')}} -</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" @if(isset($user->details->city_id) && $user->details->city_id == $city->id) selected @endif data-country="{{$city->country_id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                            @error('city_id')
                                            <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="field-label">{{__('User.State / County')}}</label>
                                        <select name="state" id="state_id" class="form-control" required="">
                                            <option value="">- {{__('User.Town/State')}} -</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" @if(isset($user->details->state) && $user->details->state == $state->id) selected @endif data-city="{{$state->city_id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                        <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="field-label">{{__('User.Postal Code')}}</label>
                                        <input type="number" name="postal_code" class="form-control" value="{{isset($user->details->postal_code) ? $user->details->postal_code : ''}}">
                                        @error('postal_code')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="field-label">{{__('User.Password (Leave Empty To Keep Current)')}}</label>
                                        <input type="password" name="password" class="form-control">
                                        @error('password')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="field-label">{{__('User.Password Confirm')}}</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                        @error('password_confirmation')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        <button class="btn btn-lg btn-rounded mr-10" style="background-color: green;">{{__('User.Save Setting')}}</button>
                        </form>
                        <!-- <a href="cart.html" class="btn btn-lg btn-warning btn-rounded" style="background-color: #b22827;">Cancel </a> -->
                    </section>
                    <!-- End Checkout Area -->

                </div>
            </div>
        </div>
    </div>
    <!-- End Page Container -->


</main>

@include('website.components.footer')





@endsection

@section('javascript')

@endsection