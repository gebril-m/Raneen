<!--footer start-->
<footer class="footer-2">
    <div class="container ">
        <div class="row">
            <div class="col-12">
                <div class="footer-main-contian">
                    <div class="row ">
                        <div class="col-lg-4 col-md-12 ">
                            <div class="footer-left">
                                <div class="footer-logo">
                                    <a href="{{url('/'.$locale)}}"><img src="{{asset('/media/main/logo.png')}}" class="img-fluid  " alt="logo"></a>
                                </div>
                                <div class="footer-detail">
                                    <p>{{trans('home.Description')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 ">
                            <div class="footer-right">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="subscribe-section">
                                            <div class="row">
                                                <div class="col-md-5 ">
                                                    <div class="subscribe-block">
                                                        <div class="subscrib-contant ">
                                                            <h4>{{trans('home.subscribe to newsletter')}}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 ">
                                                    <div class="subscribe-block">
                                                        <div class="subscrib-contant">
                                                            <div class="input-group" >
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" ><i class="fa fa-envelope-o" ></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="your email" >
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text telly" ><i class="fa fa-telegram" ></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class=account-right>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="footer-box">
                                                        <div class="footer-title">
                                                            <h5>{{trans('home.quick link')}}</h5>
                                                        </div>
                                                        <div class="footer-contant">
                                                            <ul>
                                                                @foreach($page_footer as $footer)
                                                                <li><a href="{{url('/'.$locale.'/'.$footer->slug.'/page')}}">{{$footer->name}}</a></li>
                                                                    @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
{{--
                                                <div class="col-md-3">
                                                    <div class="footer-box">
                                                        <div class="footer-title">
                                                            <h5>quick link</h5>
                                                        </div>
                                                        <div class="footer-contant">
                                                            <ul>
                                                                <li><a href="#">store location</a></li>
                                                                <li><a href="#"> my account</a></li>
                                                                <li><a href="#"> orders tracking</a></li>
                                                                <li><a href="#"> size guide</a></li>
                                                                <li><a href="#">FAQ </a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
--}}
                                                <div class="col-md-5">
                                                    <div class="footer-box footer-contact-box">
                                                        <div class="footer-title">
                                                            <h5>{{trans('home.contact us')}}</h5>
                                                        </div>
                                                        <div class="footer-contant">
                                                            <ul class="contact-list">
                                                                <li><i class="fa fa-map-marker"></i><span>{{trans('home.address')}}</span></li>
                                                                <li><i class="fa fa-phone"></i><span>{{trans('home.call us')}}: {{trans('home.phone')}}</span></li>
                                                                <li><i class="fa fa-envelope-o"></i><span>{{trans('home.email us')}}: {{trans('home.email')}}</span></li>
                                                                <li><i class="fa fa-fax"></i><span>{{trans('home.fax us')}} {{trans('home.fax_number')}}</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-link-block  bg-transparent">
        <div class="container">
            <div class="row">
                <div class="app-link-bloc-contain app-link-bloc-contain-1">
                    <div class="app-item-group">
                        <div class="app-item">
                            <img src="{{asset('/assets/images/layout-1/app/1.png')}}" class="img-fluid" alt="app-banner">
                        </div>
                        <div class="app-item">
                            <img src="{{asset('/assets/images/layout-1/app/2.png')}}" class="img-fluid" alt="app-banner">
                        </div>
                    </div>
                    <div class="app-item-group ">
                        <div class="sosiyal-block" >
                            <h6>{{trans('home.follow us')}}</h6>
                            <ul class="sosiyal">
                                <li><a href="#"><i class="fa fa-facebook" ></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus" ></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" ></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" ></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" ></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sub-footer-contain">
                        <p><span>2018 - 19 </span>{{trans('home.copy right')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer end-->


<!-- tap to top -->
<div class="tap-top">
    <div>
        <i class="fa fa-angle-double-up"></i>
    </div>
</div>
<!-- tap to top End -->

<!-- Add to cart bar -->
<div id="cart_side" class=" add_to_cart top">
    <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my cart</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeCart()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">

            <ul class="cart_product" id="cartlist_items">
                
            </ul>
            <ul class="cart_total" id="cartlist_total">

            </ul>

        </div>
    </div>
</div>
<!-- Add to cart bar end-->



<!-- Quick-view modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content quick-view-modal">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="{{asset('/assets/images/layout-2/product/a1.jpg')}}" alt="" class="img-fluid "></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right product-dsec ">
                            <h2 data-type="name">Women Pink Shirt</h2>
                            <h3>$<span class="product-right_price" data-type="price" value=""> 32.96 </span></h3>
                            <div class="border-product prodect_details_read">
                                <h6 class="product-title">{{ __('words.product_details') }}</h6>
                                <p class="prodect_details_read" data-type="description">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
                                <span class="prodect_details_read_dots">...</span>

                            </div>
                            <button id="prodect_details_read_Btn">{{trans('home.Read more')}}</button>

                            <div class="product-buttons"><a href="javascript:void(0)" class="btn btn-normal addToCart" id="productId" productId="">add to cart</a> <a href="javascript:void(0)" class="btn btn-normal view-btn-details">view detail</a></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Quick-view modal popup end-->




<!-- My account bar start-->
<div id="myAccount" class="add_to_cart right account-bar">
                                    
    <a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>{{trans('home.my account')}}</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeAccount()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <form class="theme-form" method="POST" action="{{ route('login') }}">
        @csrf
            <div class="form-group">
            <label for="email">{{trans('home.email')}}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
            <label for="review">{{trans('home.Password')}}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror   
            </div>
            <div class="form-group">
                <button href="#" class="btn btn-rounded btn-block" type="submit">{{trans('home.Login')}}</button>
            </div>
            <div>
{{--
            <h5 class="forget-class">
                <a class="d-block" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
            </h5>
--}}
                <h6 class="forget-class">
                <a href="{{route('register')}}" class="d-block">{{trans('home.new to store? Signup now')}}</a>
                </h6>
            </div>
        </form>
        <div class="theme-form" id="side-social-wrapper">
        <hr>
        
        <a class="btn btn-facebook" href="{{route('web.login.facebook')}}">
            {{ __('Login With Facebook') }}
        </a>
        <a class="btn btn-google" href="{{route('web.login.google')}}">
            {{ __('Login With Google') }}
        </a>
        <a class="btn btn-twitter" href="{{route('web.login.twitter')}}">
            {{ __('Login With Twitter') }}
        </a>
        </div>
    </div>
</div>
<!-- Add to account bar end-->

<!-- Add to wishlist bar -->
<div id="wishlist_side" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeWishlist()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my wishlist</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeWishlist()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="cart_media">
            <ul class="cart_product" id="wishlist_items">
            </ul>
            <ul class="cart_total wishlist-custom" id="wishlist_total">
                
            </ul>
        </div>
    </div>
</div>
<!-- Add to wishlist bar end-->

<!-- add to  setting bar  start-->
<div id="mySetting" class="add_to_cart right">
    <a href="javascript:void(0)" class="overlay" onclick="closeSetting()"></a>
    <div class="cart-inner">
        <div class="cart_top">
            <h3>my setting</h3>
            <div class="close-cart">
                <a href="javascript:void(0)" onclick="closeSetting()">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="setting-block">
            <div >
                <h5>language</h5>
                <ul>
                    <li><a href="#">english</a></li>
                    <li><a href="#">french</a></li>
                </ul>
                <h5>currency</h5>
                <ul>
                    <li><a href="#">uro</a></li>
                    <li><a href="#">rupees</a></li>
                    <li><a href="#">pound</a></li>
                    <li><a href="#">doller</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- facebook chat section end -->

<!-- notification product -->
{{--
<div class="product-notification" id="dismiss">
    <span  onclick="dismiss();" class="close" aria-hidden="true">×</span>
    <div class="media">
        <img class="mr-2" src="{{asset('/assets/images/layout-1/product/5.jpg')}}" alt="Generic placeholder image">
        <div class="media-body">
            <h5 class="mt-0 mb-1">Latest trending</h5>
            Cras sit amet nibh libero, in gravida nulla.
        </div>
    </div>
</div>
--}}
<!-- notification product -->
<script>

</script>
