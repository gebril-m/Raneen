<div class="main-slider" id="home"  style="background-image: url({{ asset('website/images/slider.png') }}); background-repeat: repeat-x;">
        <div class="container">
          <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12 banner-left hidden-xs"><img src="../images/banner-left.jpg" alt="banner"></div>
            <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12 jtv-slideshow">
              <div id="jtv-slideshow">
                <div id='rev_slider_4_wrapper' class='rev_slider_wrapper fullwidthbanner-container' >
                  <div id='rev_slider_4' class='rev_slider fullwidthabanner'>
                    <ul>

                      @foreach($slider as $data)

                      @php
                        $index = $loop->index + 1;
                        $product = isset($data->product) ? \App\Product::find($data->product) : null;
                        if (!$product) continue;
                  @endphp

                  <li data-transition='fade' data-slotamount='7' data-masterspeed='1000' data-thumb=''>
                    <a href="{{ $product ? $product->url : '' }}" class="slider-link">
                      <img src='{{ image('module', $data->image) }}' " data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' alt="banner"/>
                    </a>
                    <div class="caption-inner" >
                      <div class='tp-caption sfb  tp-resizeme '  data-x='370'  data-y='280'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'><a  style='border-radius:10px' href='{{ $product ? $product->url : '' }}' class="buy-btn">{{__('Shop.Shop Now')}}</a> </div>
                    </div>
                  </li>
                  @endforeach

                </ul>
                <div class="tp-bannertimer"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
