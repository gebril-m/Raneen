@extends('website.layouts.master')

@section('title',__('Login.verify'))

@section('stylesheet')

@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')
<!-- breadcrumb start -->

<!-- breadcrumb End -->
<br><br>
<br><br>
<!-- section start -->
<!--section start-->
<!--section start-->
<section class="login-page section-big-py-space bg-light">
    <div class="custom-container">
        <div class="row">
            <div class="col-xs-12" style="background-color:white;">
                <div class="theme-card" style="max-width:300px;margin:auto">
                    <h3 class="text-center">{{__('Login.Verify Your Account')}}</h3>
                    <hr>
                    @if( session()->has('verification_code_resent') )
                    <div class="alert alert-success">
                        <strong>{{__('LoginVerification Code Resent Successfully')}}</strong>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('web.account.verify') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{__('Login.Account Verification Code')}}</label>
                            <input id="verification_code" type="text" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" value="{{ old('verification_code') }}" required autocomplete="verification_code" autofocus>
                            @if( session()->has('verification_error') )
                            <span class="error" role="alert">
                                <strong style="color: red;font-size: 15px;">{{ session()->get('verification_error') }}</strong>
                            </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-normal" style="width:150px;margin:auto;display:block">
                            {{ __('Submit') }}
                        </button>
                    </form>
                    <a href="{{ route('web.account.verify.resend') }}" style="text-align: center;display: block;margin: auto;font-size: 20px;text-decoration: underline;padding: 10px;color: black;color:black">{{__('Login.Resend Verification Code')}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<br><br>
<br><br>
<!--Section ends-->
@include('website.components.footer')





@endsection

@section('javascript')

@endsection
