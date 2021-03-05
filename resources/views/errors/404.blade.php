@extends('website.layouts.master')

@section('title',__('Page.Error'))

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')
   

<div class="error-page">
    <div class="container">
      <div class="error_pagenotfound"> <strong>4<span id="animate-arrow">0</span>4 </strong> <br />
        <b>{{__('home.oops')}}</b> <em>{{__('home.page_not_found')}}</em>
        <p>{{__('home.use_button')}}</p>
        <br />
        <a href="{{url('/')}}" class="button-back"><i class="icon-arrow-left-circle icons"></i>&nbsp; {{__('home.back to home')}}</a> </div>
      <!-- end error page notfound --> 
      
    </div>
  </div>

@include('website.components.footer')

@endsection

@section('javascript')

@endsection





