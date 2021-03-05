@if($content)
    <!--collection banner start-->
    {{--<section class="collection-banner section-pb-space ">
        <div class="custom-container">
            <div class="row">
                <div class="col">
                    <div class="collection-banner-main banner-5 p-center">
                        <div class="collection-img">
                        </div>
                        <div class="collection-banner-contain ">
                            <div class="sub-contain">
                                @php
                                    $product = \App\Product::find($content->product);
                                @endphp
                                {{ $content->date }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>--}}
    <!--collection banner end-->

    @php
        $products = \App\Product::where('on_sale','=',1)
            ->where('is_active', '=',1)
            ->where('stock', '>', 0)
            ->where('hot_ends_at', '>', now())->get();
    @endphp

    <!--hot deal start-->
    <section class="hot-deal b-g-white section-big-pb-space space-abjust">
        <div class="custom-container">
            <div class="row hot-2">
                <div class="col-12">
                    <!--title start-->
                    <div class="title3 b-g-white text-left">
                        <h4>{{ __('modules.today_hot_deal') }}</h4>
                    </div>
                    <!--titel end-->
                </div>

                <div class="col-lg-12">
                    <div class="slide-1 no-arrow">
                        @foreach($products as $product)
                            <div>
                                <div class="hot-deal-contain deal-abjust">
                                    <div class="row hot-deal-subcontain">
                                        <div class="col-lg-4 col-md-4 ">
                                            <div class="hotdeal-right-slick border-0">
                                                @foreach($product->images as $image)
                                                    <div><img src="{{ $image->image }}" alt="{{ $product->name }}" class="img-fluid  "></div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="hot-deal-center">
                                                <div>
                                                    <div>
                                                        <a href="{{ $product->url }}"><h5>{{ $product->name }}</h5></a>
                                                    </div>
                                                    <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div>
                                                        <p>{!! words_limit(strip_tags($product->description), 1000) !!}</p>
                                                        <div class="price">
                                                            <span>${{ number_format($product->price) }}</span>
                                                            <span>${{ number_format($product->before_price) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="timer">
                                                        <p id="product-counter-{{ $product->id }}">
                                                            <span>-<span>days</span></span>
                                                            <span>-<span>hrs</span></span>
                                                            <span>-<span>min</span></span>
                                                            <span>-<span>sec</span></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="hotdeal-right-nav">
                                                @foreach($product->images as $image)
                                                    <div><img src="{{ $image->image }}" alt="{{ $product->name }}" class="img-fluid"></div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--hot deal start-->

@endif


<script>
    /*=====================
      timer js
     ==========================*/

    (function() {
        "use strict";

//    Set the date we're counting down to  //x(countDownDate , demo)
        var countDownTimer= function ( countDate ,idElement, countDownIsOver ){
            var countDownDate = new Date(countDate).getTime();

            //    Update the count down every 1 second
            var x = setInterval(function() {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                document.getElementById(idElement).innerHTML = "<span>" + days + "<span class='padding-l'>:</span><span class='timer-cal'>Days</span></span>" + "<span>" + hours + "<span class='padding-l'>:</span><span class='timer-cal'>Hrs</span></span>"
                    + "<span>" + minutes + "<span class='padding-l'>:</span><span class='timer-cal'>Min</span></span>" + "<span>" + seconds + "<span class='timer-cal'>Sec</span></span> ";


                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(idElement).innerHTML = countDownIsOver;
                }
            }, 1000);

        }

        @foreach($products as $product)
        countDownTimer("{{ $product->hot_ends_at }}","product-counter-{{ $product->id }}","EXPIRED")//countDownTimer( countDownDate ,idElement, countDownIsOver )
        @endforeach
        // countDownTimer("dec 5, 2019 15:37:25","demo1","EXPIRED")//countDownTimer( countDownDate ,idElement, countDownIsOver )

    })();


</script>
