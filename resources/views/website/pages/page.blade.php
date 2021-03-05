@extends('website.layouts.master')

@section('title',$page->name)

@section('content')

@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')

@if($contact)
<div class="main container">
    <div style="padding:20px;">
        @include('pages.contact')
    </div>
</div>
@else
<div class="main container">
    <div class="about-page">
        {!! $page->body !!}
    </div>
</div>
@endif


@include('website.components.news-letter')
@include('website.components.footer')

@endsection