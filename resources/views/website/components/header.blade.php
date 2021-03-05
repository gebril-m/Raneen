<header>
    <input type="hidden" id="header_currency" value="{{__('product.currency')}}" >
    <input type="hidden" id="header_qty" value="{{__('Product.Quantity')}}" >
    <div class="header-container">
      <div class="header-top">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 col-md-4 col-sm-4 col-xs-4"> 
              <!-- Default Welcome Message -->
              <div class="welcome-msg hidden-xs hidden-sm"> </div>
              <!-- Language &amp; Currency wrapper -->
              <div class="language-currency-wrapper">
                <div class="inner-cl">
                  <div class="block block-language form-language">
                    @if (\Lang::getLocale() == 'en')
                    <div class="lg-cur"><a href="{{replaceLang('ar')}}"><img src="{{ asset('website/images/ar.png') }}" alt="" srcset="">عربى</a></div>
                    @else
                    <div class="lg-cur"><a href="{{replaceLang('en')}}"><img src="{{ asset('website/images/en.png') }}" alt="" srcset="">English</a></div>
                    @endif
                  </div>
                  <div class="block block-currency" style="display: none">
                    <div class="item-cur"><span>USD</span><i class="fa fa-angle-down"></i></div>
                    <ul>
                      <li><a href="#"><span class="cur_icon">€</span>EUR</a></li>
                      <li><a href="#"><span class="cur_icon">¥</span>JPY</a></li>
                      <li><a class="selected" href="#"><span class="cur_icon">$</span>USD</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- top links -->
            <div class="headerlinkmenu col-md-8 col-sm-8 col-xs-8"> <span class="phone  hidden-xs hidden-sm"> <i class="fa fa-phone"> {{__('home.call us')}} :</i> <span>@if($locale == "en" ) +  @endif 123.456.789 @if($locale == "ar" ) +  @endif </span></span>
              <ul class="links">
                <!-- <li class="hidden-xs"><a title="Help Center" href="#"><span>Help Center</span></a></li>
                <li><a title="Store Locator" href="#"><span>Store Locator</span></a></li>
                <li><a title="Checkout" href="#"><span>Checkout</span></a></li> -->

                @if(!Auth::user())
                <li><a title="login" href="{{ url('/'.$locale.'/login') }}"><span style="color:yellow;">{{__('Login.Login')}}</span></a></li>
                <li><a title="register" href="{{ url('/'.$locale.'/register') }}"><span style="color:yellow;">{{__('Login.Register')}}</span></a></li>
                @else
                <li>
                  <div class="dropdown"><a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><span style="color: yellow;">
                  @if(isset(Auth::user()->details->first_name))
                  {{Auth::user()->details->first_name}} {{Auth::user()->details->last_name}}
                  @else
                  {{Auth::user()->name}}
                  @endif
                </span> <i class="fa fa-angle-down"></i></a>
                    <ul style="background-color: #272727;width:200px ; padding:12px" class="dropdown-menu  dropdown-menu-po" role="menu" style="z-index: 1001;"  >
                    <li style="color: #fff"> <span class="ti-user" style="font-size: 15px;"></span><a  style="font-size:15px" href="{{url('/'.$locale.'/user/profile/'.Auth::user()->id)}}">{{__('User.Account Dashboard')}}</a></li>
                <li  style="color: #fff"> <span class="ti-server" style="font-size: 15px"><a    href="{{url('/'.$locale.'/user/points')}}">{{__('User.Points')}}</a></li>
                <li  style="color: #fff"> <span class="ti-email" style="font-size: 15px"><a   href="{{url('/'.$locale.'/user/complaints')}}">{{__('User.Complaints')}}</a></li>
                <li  style="color: #fff"> <span class="ti-menu-alt" style="font-size: 15px"><a   href="{{url('/'.$locale.'/order/history')}}">{{__('User.Order History')}}</a></li>
                <li  style="color: #fff"> <span class="ti-wallet" style="font-size: 15px"><a   href="{{url('/'.$locale.'/user/wallet')}}">{{__('User.Wallet')}}</a></li>
                <li  style="color: #fff"> <span class="ti-heart" style="font-size: 15px"><a   href="{{url('/'.$locale.'/wishlist')}}">{{__('User.Wishlist')}}</a></li>
                <li  style="color: #fff"> <span class="ti-shopping-cart" style="font-size: 15px"><a   href="{{url('/'.$locale.'/cart')}}">{{__('User.Cart')}}</a></li>

                      <li style="border-top: 1px solid #fff;color:white">
                      <span class="ti-shift-left" style="font-size: 15px">
                        <form method="post" action="{{route('logout')}}" id="logout_form">
                            @csrf
                            <a href="#" onclick="document.getElementById('logout_form').submit();" style="color: white;">
                                {{trans('home.logout')}}
                            </a>
                        </form>
                    </li>
                    </ul>
                  </div>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- header inner -->
      <div class="header-inner">
        <div class="container">
          <div class="row">
            <div class="col-sm-3 col-xs-12 jtv-logo-block"> 
              
              <!-- Header Logo -->
              <div class="logo"><a title="e-commerce" href="{{url('/'.$locale)}}"><img alt="ShopMart" title="ShopMart"  style="height: 60px;" src="{{ asset('website/images/logo.png') }}"></a> </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-6 jtv-top-search"> 
              
              <!-- Search -->
              
              <div class="top-search">
                <div id="search">
                  <form action="{{url('/search')}}" method="get">
                    @csrf
                    <div class="input-group">
                      <select class="cate-dropdown hidden-xs hidden-sm" name="category_id">
                        <option value="0">{{ __('home.All Categories') }}</option>
                        @if(count($categories) > 0)
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        @endif
                      </select>
                      <input type="text" class="form-control" placeholder="{{ __('home.Enter Your Search') }}" name="search">
                      <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                  </form>
                </div>
              </div>
              
              <!-- End Search --> 
              
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 top-cart layout-header2">
            <div class="link-wishlist" title="wishlist"> 
              <a href="{{url('/'.$locale.'/wishlist')}}"> 
                <i class="icon-heart icons" style="color:black"></i>
                      @if(Auth::check())
                        <span class="cart-total cart-product wishlist-product" @if(count(getWishlistUser()) == 0) style="display: none" @endif >
                        {{count(getWishlistUser())}}
                        </span>
                      @else
                        <span class="cart-total cart-product wishlist-product" @if(count(getWishSession()) == 0) style="display: none" @endif >
                        {{count(getWishSession())}}
                        </span>
                      @endif  
                    </span>
                  </a> 
                    <!-- <span> {{__('home.wishlist')}}</span> -->
                </div>

                <!-- compare -->
                <div class="link-wishlist" title="compare"> 
              <a href="{{url('/'.$locale.'/compare')}}"> 
                <i class="ti-layout-grid2" style="color:black"></i><span class="cart-total cart-product compare_counter" @if(getCompareSession() == 0) style="display: none" @endif >
                  {{getCompareSession()}}
                </span>
                  </a> 
                </div>
                
                <!-- compare -->




              <!-- top cart -->
              <div class="top-cart-contain website_opencart" title="cart" style="margin-left:81px;">
                <div class="mini-cart">
                  <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle cart-block cart-hover-div "  > <a href="#" class="open-drop-cart">
                    <div class="cart-icon cart"><i class="icon-basket-loaded icons"></i><span class="cart-total cart-product website_cart_counter"  @if($cart_counter == 0) style="display: none" @endif>{{ $cart_counter }}</span></div>
                    <div class="shoppingcart-inner hidden-xs">
                    <span class="cart-title"></span>
                     </div>
                    </a></div>
                  <div>
                    
                  </div>
                  <div>
                    <div class="top-cart-content">
                        <div class="block-subtitle hidden">{{__('User.Recently added items')}}</div>
                        <ul id="cart-sidebar" class="mini-products-list">


                        </ul>
                        <div class="top-subtotal">{{__('User.Subtotal')}}: <span class="price"></span></div>
                        <div class="actions">
                            <button class="btn-checkout" type="button" onclick="location.href='{{url('/'.$locale.'/checkout')}}'"><i class="fa fa-check"></i><span>{{__('User.Checkout')}}</span></button>
                            <button class="view-cart" type="button" onclick="location.href='{{url('/'.$locale.'/cart')}}'"><i class="fa fa-shopping-cart"></i><span>{{__('User.View Cart')}}</span></button>
                        </div>
                    </div>
                </div>
                </div>
              </div>


              <!-- (Sherif) Invalid Code - Please Review it (Sherif) -->
              <!--<div class="top-cart-contain">
                {{-- {{ dd(getWishSession()) }} --}}
                <div class="mini-cart">
                  <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle"> <a href="#">
                    <div class="cart-icon"><i class="icon-basket-loaded icons"></i><span class="cart-total cart-product wishlist-product">
                      @if(Auth::check())
                      {{count(getWishlistUser())}}
                          @else
                      {{count(getWishSession())}}
                      @endif  
                    </span></div>

                     <div class="shoppingcart-inner hidden-xs"><span class="cart-title">Wishlist</span> </div>
                    </a></div> 

                </div>
              </div>

            </div>-->
          </div>
        </div>
      </div>
    </div>
  </header>


  {{-- Cart Modal --}}
  
  <div class="modal fade bd-example-modal-lg" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-top: 6px solid #b22827;border-radius: 0;border-bottom: 6px solid #b22827;">
        <div class="modal-header">
          <div class="cart_top">
            <h3 style="text-align: center;background: #b22827;display: block;width: 40%;margin-left: auto;margin-right: auto;color: white;padding: 5px;border-radius: 50px;">{{(__('Home.My Cart'))}}</h3>
        </div>
        </div>
        
        <div class="modal-body">
          <div id="cart_side" class=" add_to_cart top">
            <a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
            <div class="cart-inner">
                
                <div class="cart_media">
                  <div class="row">
                    <ul class="cart_product" id="cartlist_items">
                        
                    </ul>
                  </div>
                    <hr>
                    <div class="row" style="padding: 5px;margin-left: auto;margin-right: auto;">
                      <ul class="cart_total" id="cartlist_total">
        
                      </ul>
                    </div>
        
                </div>
            </div>
        </div>
        </div>
        
      </div>
    </div>
  </div>