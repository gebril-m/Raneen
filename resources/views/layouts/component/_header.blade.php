<!-- loader start -->
<div class="loader-wrapper">
    <div>
        <img src="{{asset('/assets/images/loader.gif')}}" alt="loader">
    </div>
</div>
<!-- loader end -->

@php
    $mainCategories = \App\Category::whereIsActive(true)->whereParentId(0)->get();
@endphp

<!--header start-->
<script>
    window.translationxxxx=" this translationxxxx"

</script>
<header>
    <div class="mobile-fix-option">
        <div class="mobile-bar">
            <div class="mobile-icon-link">
                 <a href="javascript:void(0)" onclick="openCart()">
                    <i class="icon-shopping-cart "></i>
                </a>
            </div>
            <div class="mobile-icon-link">
                <a href="javascript:void(0)" onclick="openWishlist()">
                    <i class="icon-heart"></i>
                </a>
            </div>
            <div class="mobile-icon-link">
                <a href="javascript:void(0)" onclick="openAccount()">
                    <i class="icon-user"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- <div class="alert" style="background: #b33128 !important; margin-bottom: -5px; border: 1px #000 solid;">
        <h5 class="text-center text-white">        هذا الموقع تحت الانشاء وكل ما فيه من بيانات مجرد اختبار
        </h5>
    </div> -->

    <div class="top-header">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-5 col-md-7 col-sm-6">
                    <div class="top-header-left">
                        <div class="shpping-order">
                            <h6>{{trans('home.free shipping')}} </h6>
                        </div>
                        <div class="app-link">
                            <h6>
                                {{trans('home.download app')}}
                            </h6>
                            <ul>
                                <li><a><i class="fa fa-apple" ></i></a></li>
                                <li><a><i class="fa fa-android" ></i></a></li>
                                <li><a><i class="fa fa-windows" ></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-md-5 col-sm-6">
                    <div class="top-header-right">

                        <div class="language-block">
                            <div class="language-dropdown">
                  <span  class="language-dropdown-click">
                   @if($locale == 'ar') عربي @else english @endif<i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                                <ul class="language-dropdown-open">
                                    <li><a href="{{replaceLang('ar')}}">عربي</a></li>
                                    <li><a href="{{replaceLang('en')}}">english</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layout-header2">
        <div class="container-95">
            <div class="col-md-12">
                <div class="main-menu-block">
                    <div class="sm-nav-block">
                        <span class="sm-nav-btn"><i class="fa fa-bars"></i></span>
                        <ul class="nav-slide">
                            <li>
                                <div class="nav-sm-back">
                                    back <i class="fa fa-angle-right pl-2"></i>
                                </div>
                            </li>
                            @foreach($categories as $cat)
                                <li><a href="{{ $cat->url }}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="logo-block">
                        <a href="{{url('/'.$locale)}}"><img src="{{asset('/media/main/logo.png')}}" class="img-fluid  " alt="logo"></a>
                    </div>
                    <div class="input-block">
                        <div class="input-box">
                            <!-- header search form -->
                            <form class="big-deal-form" action="{{route('web.products.search')}}">
                                <div class="input-group ">
                                    <div class="input-group-prepend" id="header_search_form_submit">
                                        <span class="search">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input name="name" value="{{isset($_GET['name'])?$_GET['name']:''}}" type="text" class="form-control" placeholder="Search a Product" required>

                                    <div >
                                        <select  name="cat">
                                            <option value="">{{trans('home.All Category')}}</option>
                                            @foreach($allcategories as $cat)
                                                @if(isset($_GET['cat']))
                                                    @if($_GET['cat'] == $cat->slug)
                                                        <option value="{{$cat->slug}}" selected>{{$cat->name}}</option>
                                                    @endif
                                                    @endif
                                                <option value="{{$cat->slug}}">{{$cat->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <!-- /header search form -->
                        </div>
                    </div>

                    <div class="cart-block cart-hover-div " onclick="openCart()">
                        <div class="cart ">
                            <span class="cart-product">
                                    {{ $cart_counter }}
                            </span>
{{--
                            <span class="cart-totalPrice">
                            @if(session()->has('products.cart'))
                                     {{(session()->get('cart.totalPrice'))}}
                                @else
                                    0
                                @endif
                            </span>
--}}
                            <ul>
                                <li class="mobile-cart">
                                    <a href="javascript:void(0)">
                                        <i class="icon-shopping-cart "></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="cart-item">
{{--                            <h5> {{trans('home.shopping')}}</h5>--}}
                            <!-- <h5>{{trans('home.cart')}}</h5> -->
                            <h5>عربة التسوق</h5>

                        </div>
                    </div>
                    <div class="cart-block cart-hover-div " onclick="openWishlist()">
                        <div class="cart ">
                            <span class="cart-product wishlist-product">
                                @if(Auth::check())
                                {{count(getWishlistUser())}}
                                    @else
                                {{count(getWishSession())}}
                                @endif
                            </span>
                            <ul>
                                <li class="mobile-cart">
                                    <a href="javascript:void(0)">
                                        <i class="icon-heart"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="cart-item">
                            <!-- <h5>{{trans('home.wishlist')}}</h5> -->
                            <h5>المفضلة</h5>
                        </div>
                    </div>
                    <div class="cart-block cart-hover-div ">
                        <div class="cart ">

                            <ul>
                                <li class="mobile-cart" @if(!Auth::check()) onclick="openAccount()" @endif>

                                        <i class="icon-user"></i>

                                </li>
                            </ul>
                        </div>
                        <div class="cart-item">
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <li class="main-menu-navs_list">
                                        @if(Auth::check())
                                        <a href="#" class="dark-menu-item has-submenu mt-2" style="color: #b33128; padding-right:0px !important;">  {{ (isset(Auth::user()->details->first_name)) ? Auth::user()->details->first_name : '' }} <span class="sub-arrow" style="top:40%;"></span></a>
                                        @else
                                        <a href="#" onclick="openAccount()"class="dark-menu-item has-submenu mt-2" style="color: #b33128; padding-right:0px !important;">تسجيل الدجول</a> 
                                         <!-- {{trans('home.login')}} -->
                                        @endif
                                        @if(Auth::check())

                                        <ul id="sm-1576075883118922-2" role="group" aria-hidden="true" aria-labelledby="sm-1576075883118922-1" aria-expanded="false">
                                            <li>
                                                <a href="{{url('/'.App::getLocale().'/user/profile/'.Auth::user()->id)}}">
                                                    {{trans('home.User Profile')}}
                                                </a>
                                            </li>
                                            <li>
                                                                                            <a href="{{route('web.order.history')}}">
                                                                                                {{trans('home.Order History')}}
                                                                                            </a>
                                                                                        </li>
                                            <li style="border-top: 1px solid black; width: 100%">
                                                <form method="post" action="{{route('logout')}}" id="logout_form">
                                                    @csrf
                                                    <a href="#" onclick="document.getElementById('logout_form').submit();">
                                                        {{trans('home.logout')}}
                                                    </a>
                                                </form>
                                            </li>

                                                                                </ul>

                                        @endif

                            </li>
</ul>


                    </div>
                    </div>

                    <div class="menu-nav">
              <span class="toggle-nav">
                <i class="fa fa-bars"></i>
              </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="category-header-2">
        <div class="custom-container">
            <div class="row">
                <div class="col padding-0">
                    <div class="navbar-menu">
                        <div class="category-left">
                          <div class="nav-block" style="display: block">
                                <div class="nav-left" >
                                    <nav class="navbar" data-toggle="collapse" data-target="#navbarToggleExternalContent">
                                        <h5 class="mb-0  text-white title-font"><a href="{{url('/allcategories')}}">{{trans('home.Shop by category')}}</a></h5>
                                    </nav>
                                    <div class="collapse  nav-desk" id="navbarToggleExternalContent">
                                    </div>
                                </div>
                            </div>
                            <div class="menu-block">
                                <nav id="main-nav">
                                    <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                    <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                        <li >
                                            <div class="mobile-back text-right">{{trans('home.Back')}}<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                        </li>
                                        <div class="d-block d-sm-none">
                                            <li class="main-menu-navs_list">
                                                @if(Auth::check())
                                                    <a href="#" class="dark-menu-item">  Welcome {{ (isset(Auth::user()->details->first_name)) ? Auth::user()->details->first_name : '' }}</a>
                                                @else
                                                    <a href="#" onclick="openAccount()" class="dark-menu-item" >{{trans('home.login')}}</a>
                                                @endif
                                            </li>
                                        @if(Auth::check())

                                                <li class="main-menu-navs_list">
                                                    <a href="{{url('/'.App::getLocale().'/user/profile/'.Auth::user()->id)}}" class="dark-menu-item">
                                                        {{trans('home.User Profile')}}
                                                    </a>
                                                </li>
                                                <li class="main-menu-navs_list">
                                                    <a href="{{route('web.order.history')}}" class="dark-menu-item">
                                                        {{trans('home.Order History')}}
                                                    </a>
                                                </li>
                                                <li class="main-menu-navs_list">
                                                    <form method="post" action="{{route('logout')}}" id="logout_form">
                                                        @csrf
                                                        <a href="#" onclick="document.getElementById('logout_form').submit();" class="dark-menu-item">
                                                            {{trans('home.logout')}}
                                                        </a>
                                                    </form>
                                                </li>


                                            @endif

                                            <li class="main-menu-navs_list"><a href="#" class="dark-menu-item"  onclick="openWishlist()">{{trans('home.WishList')}}
                                                    (<span class="cart-product wishlist-product">@if(Auth::check()){{count(getWishlistUser())}}@else{{count(getWishSession())}}@endif </span>)</a></li>
                                            <li class="main-menu-navs_list cart-link"><a href="#" class="dark-menu-item"  onclick="openCart()">{{trans('home.Cart')}} <span class="cart-product"> ( {{ $cart_counter }} )</span></a></li>


                                        </div>
                                        @include('layouts.component._category')

                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</header>
<!--header end-->
