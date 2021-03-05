@extends('layouts.app')
@section('container')
    <base href="/">

    <!-- breadcrumb start -->
    <div class="breadcrumb-main ">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>{{trans('home.products')}}</h2>
                            <ul>
                                <li><a href="#"> <h2>{{trans('home.home')}}</h2></a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#"> <h2>{{trans('home.products')}}</h2></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->

    <app-root></app-root>
    {{--    <angular class="flex-center">--}}
    {{--        <div class="title m-b-md">--}}
    {{--            Loading Angular Component...--}}
    {{--        </div>--}}
    {{--    </angular>--}}

    <script src="js/runtime.js" defer></script>
    <script src="js/polyfills-es5.js" nomodule defer></script>
    <script src="js/polyfills.js" defer></script>
    <script src="js/styles.js" defer></script>
    <script src="js/vendor.js" defer></script>
    <script src="js/main.js" defer></script>

@endsection
