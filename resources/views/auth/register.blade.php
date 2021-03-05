@extends('website.layouts.master')

@section('title',__('Login.Login'))

@section('stylesheet')

@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')




    <div class="page-container ptb-60">
        <div class="container">
            <section class="sign-area panel p-40">
                <h3 class="sign-title">{{__('Register.Register')}}</small></h3>
                <div class="row row-rl-0">
                    <div class="col-sm-6 col-md-7 col-left  " style="padding: 30px;">
                    <form class="theme-form" method="post" action="{{route('create_account')}}">
                        @csrf
                            <!-- <div class="form-group">
                                <label class="sr-only">Full Name</label>
                                <input type="text" class="form-control input-lg" placeholder="Full Name">
                            </div>
                            <div class="form-group">
                              <label class="sr-only">mobile number</label>
                              <input type="text" class="form-control input-lg" placeholder="mobile number">
                          </div>
                            <div class="form-group">
                                <label class="sr-only">Email</label>
                                <input type="password" class="form-control input-lg" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label class="sr-only">Password</label>
                                <input type="password" class="form-control input-lg" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label class="sr-only">Confirm Password</label>
                                <input type="password" class="form-control input-lg" placeholder="Confirm Password">
                            </div> -->
                            <div class="form-group">
                                <label for="name" class="sr-only">{{__('User.Username')}}</label>
                                <input id="name" type="text" class="form-control input-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{__('User.Username')}}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">

                                <label for="gender" class="float-none">{{__('User.Gender')}}</label> <br>
                                <div class="card" style="border:1px solid #979797 ;border-radius:3px; background-color:white;">
                                    <div class="card-body" style="padding:11px 14px;">
                                        <div style="display:inline-block;">
                                            <input type="radio" name="gender" value="m" required> {{__('User.Male')}}
                                        </div>
                                        <div style="display:inline-block;">
                                            <input type="radio" name="gender" value="f"> {{__('User.Female')}}
                                        </div>
                                    </div>
                                </div>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="dob">Date Of Birth</label> <br>
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" required autocomplete="dob">
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="contact_number" class="sr-only">{{__('User.Contact Number')}}</label> <br>
                                <input id="contact_number" type="tel" pattern="[0-9]{11}" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact_number" placeholder="{{__('User.Contact Number')}}">
                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="sr-only">{{__('User.Email')}}</label>
                                <input id="email" type="email" style="text-align:left;direction:ltr;" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="{{__('User.Email')}}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">{{__('User.Password')}}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="review" class="sr-only">{{__('User.Password Confirm')}}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            </div>
							<div class="g-recaptcha" data-sitekey="6Leg7eMZAAAAAF5MMfwCWGJdjUvwrIJ4OINgdQEK"></div>
							  <br/>

                            <div class="form-group">
								@error('g-recaptcha-response')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="custom-checkbox mb-20">
                                <input type="checkbox" id="agree_terms" name="accept">

                                <label class="color-mid" for="agree_terms" id="agree-terms" data-toggle="modal" data-target="#agree_terms_modale">{{__('User.Accept Terms And Conditions')}}</label>

                                @error('accept')
                                    <span class="error" role="alert">
                                        <strong style="color: red;font-size: 15px;">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-block btn-lg">{{ __('Register.Register') }}</button>
                        </form>
                    </div>
                    <div class="col-sm-6 col-md-5 col-right">
                        <div class="social-login p-40">
                            <div class="mb-20">
                                <a href="{{route('web.login.facebook')}}" class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa fa-facebook-square"></i>{{ __('Register.Login With Facebook') }}</a>
                            </div>
                            <div class="mb-20">
                                <a href="{{route('web.login.twitter')}}" class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i>{{ __('Register.Register With Twitter') }}</a>
                            </div>
                            <div class="mb-20">
                                <a href="{{route('web.login.google')}}" class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i>{{ __('Register.Register With Google') }}</a>
                            </div>
                            <div class="custom-checkbox mb-20">
                                <input type="checkbox" id="remember_social" checked>
                                <label class="color-mid" for="remember_social">{{__('Login.Keep me signed in on this computer.')}}</label>
                            </div>
                            <div class="text-center color-mid">
                                {{__('Login.Need An Account?')}} <a href="{{route('login')}}" class="color-green">{{__('Login.Login')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Modal -->
<div id="agree_terms_modale" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="margin-left: 235px;" >{{$page->translate($locale)->name}}</h4>
      </div>
      <div class="modal-body">
        {!! $page->translate($locale)->body !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('home.Close')}}</button>
      </div>
    </div>

  </div>
</div>

@include('website.components.footer')





@endsection

@section('javascript')

@endsection
