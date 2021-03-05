<div class="container">
    <div class="row">
      <div class="daily-deal-section" id="hot-deal" style="background-color: #f8f8f8"> 
        <!-- daily deal section-->
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
        <!-- <ol class="carousel-indicators">
          <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example" data-slide-to="1"></li>
          <li data-target="#carousel-example" data-slide-to="2"></li>
        </ol> -->
      
        <div class="carousel-inner">
          @php $i=0 @endphp 
          @foreach($productsHasSale as $product)
          @php $i++ @endphp
          <div class="item @if($i==1) active @endif">
            <a href="#" class="row" style="margin: 20px 0;">
                  <div class="col-md-7 daily-deal" style="background-color: #f8f8f8;">
                  <h3 class="deal-title" style="color: #333">{{ __('modules.today_hot_deal') }}</h3>
                  <div class="title-divider"><span></span></div>
                  <p style="color: #666">{{ $product->name }}</p>
                  <div class="hot-offer-text">{{__('Home.Price')}} 
                    <span>
                      <span style="color: #000000">${{ number_format($product->price) }}</span>
                      <span style="text-decoration:line-through ; color:grey">${{ number_format($product->hot_price) }}</span>
                    </span>
                  </div>
                  <div class="box-timer"> <span class="des-hot-deal"style="color: #666">اسرع عرض خاص</span>
                    @php
                        $endDate = $product->hot_ends_at;
                        $dateOnly = explode(' ',$endDate)[0];
                        $timeOnly = explode(' ',$endDate)[1];
                        $secs     = explode(':',$timeOnly)[2];
                        $mins     = explode(':',$timeOnly)[1];
                        $hours    = explode(':',$timeOnly)[0];
                        $days     = explode('-',$dateOnly)[2];
                        $month    = explode('-',$dateOnly)[1];
                        $year     = explode('-',$dateOnly)[0];

                        $finalEndDate = $month.'-'.$days.'-'.$year.'-'.$hours.'-'.$mins.'-'.$secs;
                    @endphp
                    <div class="time" data-countdown="countdown" data-date="{{ $finalEndDate }}"></div>
                    <a href="{{ $product->url }}" class="link" style="margin-bottom:10px;">{{__('Home.View Detail')}}</a> </div>
            </div>
            <div class="col-md-5 hot-pr-img-area">
              <div id="daily-deal-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4 ">
                @foreach($product->images as $image)
                  <div class="pr-img-area"> 
                    <a title="{{ $product->name }}" href="{{ $product->url }}">
                    <figure> <img class="first-img" src="{{ image('product', $image->image) }}" alt="{{ $product->name }}"></figure>
                    </a> 
                  </div>
                @endforeach
                
                </div>
              </div>
            </div></a>
          
          </div>
          @endforeach
        </div>
      
        <a class="left carousel-control" href="#carousel-example" data-slide="prev" style="background: none;color: #b22827;">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example" data-slide="next" style="background: none;color: #b22827;">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>


        

      </div>
    </div>
  </div>