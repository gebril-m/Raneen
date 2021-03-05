@extends('layouts.app')
@section('container')
    <!-- breadcrumb start -->
    <div class="margin-large"></div>

    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>{{$page->name}}</h2>
                            <ul>
                                <li><a href="#"> <h2>{{trans('home.home')}}</h2></a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#"> <h2>{{$page->name}}</h2></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($contact)
        @include('pages.contact')
    @endif
    {!! $page->body !!}
@endsection