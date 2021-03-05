{{--@php($locale = \Lang::getLocale())--}}

@extends('website.layouts.master')

@section('title','Raneen')

@section('stylesheet')

@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav')
@include('website.components.slideshow')
@include('website.components.breadcrumb')
@include('website.components.services')
@include('website.components.inner-box')
@include('website.components.best-selling')
@include('website.components.deal-day')
@include('website.components.two-banner')
{{-- @include('website.components.latest-blogs') --}}
@include('website.components.banner-area')
@include('website.components.news-letter')
@include('website.components.footer')





@endsection

@section('javascript')

@endsection
