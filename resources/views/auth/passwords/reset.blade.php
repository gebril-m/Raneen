@extends('website.layouts.master')

@section('title',__('Login.Reset Password'))

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')
<!--section start-->
<section class="login-page section-big-py-space  e-w">
    <div class="custom-container">
        <div class="row">
            <div class="col-xs-12 ">
                <div class="theme-card" style="max-width: 300px;margin: auto;padding: 30px 0;">
                <h3 class="text-center">{{ __('Reset Password') }}</h3>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }} ">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email">{{ __('E-Mail Address') }}</label>

                            
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="form-group row e-l">
                            <label for="password">{{ __('Password') }}</label>

                            
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="form-group row e-l">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>

                            
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-xs-12" style="text-align: center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('User.Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->
@include('website.components.footer')





@endsection

@section('javascript')

@endsection

