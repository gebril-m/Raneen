@extends('website.layouts.master')

@section('title',__('Login.Login'))

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')


<!--section start-->
<div class="page-container ptb-60">
        <div class="container">
            <section class="sign-area panel p-40">
                <h3 class="sign-title">{{__('Login.Login')}}</h3>
                <div class="row row-rl-0">
                    <div class="col-sm-6 col-md-7 col-left" style="padding: 30px;">
                        <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <div class="form-group">
                                <label class="sr-only">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{__('User.Email Address')}}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;" >{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="sr-only">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red;font-size: 15px;" >{{ $message }}</strong>
                                </span>
                            @enderror 
                            </div>
                            <div class="form-group">
                                <a href="{{ route('password.request') }}" class="forgot-pass-link color-green">{{ __('Login.Forgot Your Password?') }}</a>
                            </div>
                            <div class="custom-checkbox mb-20">
                                <input type="checkbox" id="remember_account" checked>
                                <label class="color-mid" for="remember_account">{{__('User.Keep me signed in on this computer.')}}</label>
                            </div>
                            <button type="submit" class="btn btn-block btn-lg">{{ __('Login.Login') }}</button>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-5 col-right">
                        <div class="social-login p-40">
                            <div class="mb-20">
                                <a href="{{route('web.login.facebook')}}" class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa fa-facebook-square"></i>{{ __('Login.Login With Facebook') }}</a>
                            </div>
                            <div class="mb-20">
                                <a href="{{route('web.login.twitter')}}" class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i>{{ __('Login.Login With Twitter') }}</a>
                            </div>
                            <div class="mb-20">
                                <a href="{{route('web.login.google')}}" class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i>{{ __('Login.Login With Google') }}</a>
                            </div>
                            <div class="custom-checkbox mb-20">
                                <input type="checkbox" id="remember_social" checked>
                                <label class="color-mid" for="remember_social">{{__('Login.Keep me signed in on this computer.')}}</label>
                            </div>
                            <div class="text-center color-mid">
                                {{__('Login.Need An Account?')}} <a href="{{ url('/'.$locale.'/register') }}" class="color-green">{{__('Login.Create Account')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@include('website.components.footer')





@endsection

@section('javascript')

@endsection
