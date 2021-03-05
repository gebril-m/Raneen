<footer>
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-3 col-xs-12">
          <div class="footer-logo"><a href="{{url('/'.$locale)}}"><img src="{{ asset('website/images/logo2.png') }}" style="height: 70px;" alt="fotter logo"></a> </div>
          <p>{{trans('home.Description')}}</p>
          <div class="social">
            <ul class="inline-mode">
              <li class="social-network fb"><a title="Connect us on Facebook" target="_blank" href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
              <li class="social-network googleplus"><a title="Connect us on Google+" target="_blank" href="https://plus.google.com/"><i class="fa fa-google"></i></a></li>
              <li class="social-network tw"><a title="Connect us on Twitter" target="_blank" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
              <li class="social-network linkedin"><a title="Connect us on Pinterest" target="_blank" href="https://www.pinterest.com/"><i class="fa fa-pinterest"></i></a></li>
              <li class="social-network rss"><a title="Connect us on Instagram" target="_blank" href="https://instagram.com/"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-2 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">{{trans('home.quick link')}}<a class="expander visible-xs" href="#TabBlock-1">+</a></h3>
            <div class="tabBlock" id="TabBlock-1">
              <ul class="list-links list-unstyled">
                @foreach($page_footer as $footer)
                  <li><a href="{{url('/'.$locale.'/'.$footer->slug.'/page')}}">{{$footer->name}}</a></li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-2 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">{{trans('home.contact us')}}<a class="expander visible-xs" href="#TabBlock-3">+</a></h3>
            <div class="tabBlock" id="TabBlock-3">
              <ul class="list-links list-unstyled">
                <li><span href="sitemap.html"> {{trans('home.Address')}}</span></li>
                <li><span href="#">{{trans('home.call us')}}: {{trans('home.phone')}}</span></li>
                <li><a href="mailto:{{trans('home.email')}}" >{{trans('home.email us')}}: {{trans('home.email')}}</a></li>
                <li><span href="about_us.html">{{trans('home.fax us')}} {{trans('home.fax_number')}}</span></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-md-3 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">{{ __('home.Working Hours') }}<a class="expander visible-xs" href="#TabBlock-5">+</a></h3>
            <div class="tabBlock" id="TabBlock-5">
              <div class="footer-description"> <b>{{ __('home.Monday-Friday') }}:</b> 8.30 a.m. - 5.30 p.m.<br>
                <b>{{__('home.Saturday')}}:</b> 9.00 a.m. - 2.00 p.m.<br>
                <b>{{__('home.Sunday')}}:</b> {{__('home.Closed')}} </div>
              <div class="payment">
                <ul>
                  <li><a href="#"><img title="Visa" alt="Visa" src="{{ asset('website/images/visa.png') }}"></a></li>
                  <li><a href="#"><img title="Paypal" alt="Paypal" src="{{ asset('website/images/paypal.png') }}"></a></li>
                  <li><a href="#"><img title="Discover" alt="Discover" src="{{ asset('website/images/discover.png') }}"></a></li>
                  <li><a href="#"><img title="Master Card" alt="Master Card" src="{{ asset('website/images/master-card.png') }}"></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-coppyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-xs-12 coppyright"> {{ __('home.Copy Rights') }}  <a href="#"> Raneen </a>  </div>
          <div class="col-sm-6 col-xs-12">
            <ul class="footer-company-links">
              <li> <a href="#"><img src="{{asset('/assets/images/layout-1/app/1.png')}}" class="img-fluid" alt="app-banner"></a> </li>
              <li> <a href="#"><img src="{{asset('/assets/images/layout-1/app/2.png')}}" class="img-fluid" alt="app-banner"></a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <a href="#" id="back-to-top" title="Back to top"><i class="fa fa-angle-up"></i></a>



<!-- Quick-view modal popup end-->
