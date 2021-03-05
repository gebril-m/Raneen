
        <aside class=" sidebar col-sm-3 col-xs-12" style="padding: 30px 15px 15px ; border-radius:15px ; background-color:#272727 ; margin-bottom:50px">
          <div class="sidebar-account block">
            <div class="sidebar-bar-title">
              <h3 style="font-size: 18px; color:#fff"> {{__('User.My Account')}}</h3>
            </div>
            <div class="block-content">
              <ul>
                @if(Auth::user())
                <li style="color: #fff"> <span class="ti-user" style="font-size: 20px;"></span><a   href="{{url('/'.$locale.'/user/profile/'.Auth::user()->id)}}">{{__('User.Account Dashboard')}}</a></li>
                <li  style="color: #fff"> <span class="ti-server" style="font-size: 20px"><a    href="{{url('/'.$locale.'/user/points')}}">{{__('User.Points')}}</a></li>
                <li  style="color: #fff"> <span class="ti-email" style="font-size: 20px"><a   href="{{url('/'.$locale.'/user/complaints')}}">{{__('User.Complaints')}}</a></li>
                <li  style="color: #fff"> <span class="ti-menu-alt" style="font-size: 20px"><a   href="{{url('/'.$locale.'/order/history')}}">{{__('User.Order History')}}</a></li>
                <li  style="color: #fff"> <span class="ti-wallet" style="font-size: 20px"><a   href="{{url('/'.$locale.'/user/wallet')}}">{{__('User.Wallet')}}</a></li>
                @endif
                <li  style="color: #fff"> <span class="ti-heart" style="font-size: 20px"><a   href="{{url('/'.$locale.'/wishlist')}}">{{__('User.Wishlist')}}</a></li>
                <li  style="color: #fff"> <span class="ti-shopping-cart" style="font-size: 20px"><a   href="{{url('/'.$locale.'/cart')}}">{{__('User.Cart')}}</a></li>
                <li style="color:white">
                      <span class="ti-shift-left" style="font-size: 15px">
                        <form method="post" action="{{route('logout')}}" id="logout_form">
                            @csrf
                            <a href="#" onclick="document.getElementById('logout_form').submit();">
                                {{trans('home.logout')}}
                            </a>
                        </form>
                    </li>
              </ul>
            </div>
          </div>
        </aside>