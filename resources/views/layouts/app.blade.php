<!DOCTYPE html>
<html lang="en">
<head>
    <title>Raneen</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="big-deal">
    <meta name="keywords" content="big-deal">
    <meta name="author" content="big-deal">
    <link rel="icon" href="{{asset('/media/main/logo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('/media/main/logo.png')}}" type="image/x-icon">

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

    <!--icon css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/themify.css')}}">

    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/slick-theme.css')}}">

    <!--Animate css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/animate.css')}}">
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/bootstrap.css')}}">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/color2.css')}}" media="screen" id="color">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/raneen.css')}}" media="screen" id="color">
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/css/custom.css')}}">
    <style>
        @if($locale=='ar')
        .pixelstrap li {
            float: right !important;
        }
        @media (max-width: 1199.98px) {
            .pixelstrap li {
                float: unset !important;
            }
        }
        @endif
    </style>
    @yield('style')
</head>
<body class="bg-light @if($locale=='ar') rtl @else ltr @endif">


@include('layouts.component._header')

@yield('container')


@include('layouts.component._footer')
<!-- latest jquery-->
<script src="{{asset('/assets/js/jquery-3.3.1.min.js')}}"></script>

<!-- slick js-->
<script src="{{asset('/assets/js/slick.js')}}"></script>

<!-- popper js-->
<script src="{{asset('/assets/js/popper.min.js')}}" ></script>

{{--<!-- Timer js-->--}}
<script src="{{asset('/assets/js/menu.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('/assets/js/bootstrap.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('/assets/js/bootstrap-notify.min.js')}}"></script>

<!-- Theme js-->
<script src="{{asset('/assets/js/script.js')}}"></script>
{{--<script src="{{asset('/assets/js/slider-animat.js')}}"></script>--}}
{{-- <script src="{{asset('/assets/js/timer.js')}}"></script>--}}
<script src="{{asset('/assets/js/modal.js')}}"></script>
<script src="{{asset('/assets/js/modal.js')}}"></script>

@yield('script')

</body>
</html>
