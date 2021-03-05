<head>
<!-- Basic page needs -->
<meta charset="utf-8">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>@yield('title')</title>
<meta name="description" content="Raneen Website">
<meta name="keywords" content="Raneen Website"/>

<!-- Mobile specific metas  -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicons Icon -->
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="{{asset('/assets/css/themify.css')}}">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>
*{
font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif; 
letter-spacing: 0; 
}
.social-card-header{
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    height: 96px;
}
.social-card-header i {
    font-size: 32px;
    color:#FFF;
}
.bg-facebook {
    background-color:#3b5998;
}
.text-facebook {
    color:#3b5998;
}
.bg-google-plus{
    background-color:#dd4b39;
}
.text-google-plus {
    color:#dd4b39;
}
.bg-twitter {
    background-color:#1da1f2;
}
.text-twitter {
    color:#1da1f2;
}
.bg-pinterest {
    background-color:#bd081c;
}
.text-pinterest {
    color:#bd081c;
}
.share:hover {
        text-decoration: none;
    opacity: 0.8;
}
</style>

<!-- CSS Style -->
<link rel="stylesheet" type="text/css" href="https://www.jqueryscript.net/demo/Simple-Flexible-jQuery-Alert-Notification-Plugin-notify-js/css/notify.css">
<link rel="stylesheet" type="text/css" href="https://www.jqueryscript.net/demo/Simple-Flexible-jQuery-Alert-Notification-Plugin-notify-js/css/prettify.css">
@if (\Lang::getLocale() == 'en')
<link rel="stylesheet" href="{{ asset('website/style.css') }}">
@else
<link rel="stylesheet" href="{{ asset('website/style-ar.css') }}">
@endif

<style>
    .cartActive{
    color: red !important;
    font-weight: bold;
    }

      

    

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@yield('stylesheet')
<style>
    .buttonload {
      background-color: #ffb3b3; /* Green background */
      border: none; /* Remove borders */
      color: white; /* White text */
      padding: 12px 24px; /* Some padding */
      font-size: 16px; /* Set a font-size */
      pointer-events: none;
    }

    /* Add a right margin to each icon */
    .fa {
      margin-left: -12px;
      margin-right: 8px;
    }
</style>

</head>