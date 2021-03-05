@extends('layouts.app')
@section('container')
    <div class="clearfix"></div>
    <!-- breadcrumb start -->
    <div class="breadcrumb-main margin-large">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>{{$product->naregular-priceme}}</h2>
                            <ul>
                                <li><a href="#"> <h2>{{trans('home.home')}}</h2></a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#"> <h2>{{trans('home.product')}}</h2></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->




    <section class="showpage" id="singlePageProduct">
        <div class="collection-wrapper">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-1 col-sm-2 col-xs-12">
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-right-nav">
{{--                                    <div><img src="{{ $product->thumbnail }}" alt="" class="img-fluid  image_zoom_cls-1"></div>--}}
                                    @php $counter = 1 ;@endphp
                                    @foreach($product->images as $img)
                                        <div><img src="{{ thumb('product', 150, 150, $img->image)  }}" alt="" class="img-fluid  image_zoom_cls-{{$counter}}"></div>
                                        @php $counter = $counter+ 1 ;@endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-10 col-xs-12 order-up">
                        <div class="product-right-slick no-arrow">
{{--                            <div><img src="{{ $product->thumbnail }}" alt="" class="img-fluid  image_zoom_cls-1"></div>--}}
                            @php $counter = 1 ;@endphp
                            @foreach($product->images as $img)
                                <div><img src="{{ image('product', $img->image)  }}" alt="" class="img-fluid  image_zoom_cls-{{$counter}}"></div>
                                @php $counter = $counter+ 1 ;@endphp
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2>{{$product->name}}</h2>
                            <!-- <h4><del>$459.00</del><span>55% off</span></h4> -->
                            <h3>$ <span class="product-right_price" value="{{ $product->product_price }}">{{ $product->product_price }}</span></h3>
                            @if(isset($attrs['color']))
                                <ul class="color-variant">
                                    @foreach($attrs['color'] as $k => $attr)
                                        @if($attr['quantity'] > 0)
                                            <li data-qty="{{ array_sum($attr['quantity']) }}" date-color="{{$k}}" style="background:{{$k}}" @if($loop->index == 0) class="active" @endif ></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                            <div class="product-description border-product">
                                {{--                            <h6 class="product-title size-text">select size <span><a href="" data-toggle="modal" data-target="#sizemodal">size chart</a></span></h6>--}}
{{--
                                <div class="size-box">
                                    <ul>
                                        <li class="active"><a href="javascript:void(0)">s</a></li>
                                        <li><a href="javascript:void(0)">m</a></li>
                                        <li><a href="javascript:void(0)">l</a></li>
                                        <li><a href="javascript:void(0)">xl</a></li>
                                    </ul>
                                </div>
--}}
                                <div class="modal fade" id="sizemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">\</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body"><img src="../assets/images/size-chart.jpg" alt="" class="img-fluid "></div>
                                        </div>
                                    </div>
                                </div>

                            <!-- @foreach($attrs as $k => $attr)
                                <h6 class="product-title"> {{$k}}</h6>
                                <div class="size-box">
                                    <ul>
                                        <li>
                                            <select name="{{$k}}">
                                                <option value="">Choose {{$k}}</option>
                                                @foreach($attr as $k2 => $a)
                                    <option value=" {{ $k2 }} ">
                                                        {{ $k2 }}
                                            </option>
@endforeach
                                        </select>
                                    </li>
                                </ul>
                            </div>
@endforeach -->

                                <h6 class="product-title">{{trans('product.quantity')}}</h6>
                                <div class="qty-box">
                                    <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                        <input type="text" id="quantity_input" max="{{ $product->stock }}" name="quantity" class="form-control input-number" value="{{ ($product->stock > 0) ? 1 : 0 }}" disabled>
                                        <span class="input-group-prepend">
                                        <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                            <i class="ti-angle-right"></i>
                                        </button>
                                    </span></div>
                                </div>
                            </div>
                            <div class="product-buttons">

                                <input id="product_id" name="id" type="hidden" value="{{$product->id}}">
                                <input name="name" type="hidden" value="{{$product->name}}">
                                <input name="price" type="hidden" value="{{$product->product_price}}">
                                @if($product->stock > 0)
                                    <button class="btn btn-normal addToCart" type="submit" style="padding:13px" productId="{{$product->id}}">
                                        {{trans('product.add to cart')}}
                                    </button>
                                    <a id="buy_now_button" href="#" class="btn btn-normal">
                                        {{trans('product.buy now')}}
                                    </a>
                                @else
                                    <span class="btn btn-dark" style="padding:13px" productId="{{$product->id}}">
                                        {{trans('product.out of stock')}}
                                    </span>    
                                @endif
                            </div>
                            <div class="border-product">
                                <h6 class="product-title">{{trans('home.product details')}}</h6>
                                {!! $product->description !!}

{{--                                <div class="prodect_details_read">--}}
{{--                                    <span class="prodect_details_read_dots">...</span>--}}
{{--                                </div>--}}
{{--                                <button id="prodect_details_read_Btn">{{trans('home.Read more')}}</button>--}}
                            </div>
                            <div class="border-product">
                                <div class="product-icon">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="product-social">
                                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <input name="id" type="hidden" value="{{$product->id}}">
                                                <input name="name" type="hidden" value="{{$product->name}}">
                                                <input name="price" type="hidden" value="{{$product->product_price}}">
                                                <button class="wishlist-btn" productId="{{$product->id}}">
                                                    <i class="fa fa-heart" productId="{{$product->id}}"></i>
                                                    <span class="title-font" productId="{{$product->id}}">{{trans('home.Add To WishList')}}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="creative-card creative-inner">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
{{--
                                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Description</a>
                                    <div class="material-border"></div>
                                </li>
--}}
                                <li class="nav-item"><a class="nav-link active" id="profile-top-tab" data-toggle="tab" href="#top-profile" role="tab" aria-selected="false">{{trans('product.Details')}}</a>
                                    <div class="material-border"></div>
                                </li>

                                <li class="nav-item"><a class="nav-link" id="review-top-tab" data-toggle="tab" href="#top-review" role="tab" aria-selected="false">Write Review</a>
                                    <div class="material-border"></div>
                                </li>

                            </ul>
                            <div class="tab-content nav-material margin-top-20" id="top-tabContent">

                                <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                    <p>
                                        {!!  $product->description !!}
                                    </p>
                                </div>

                                <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                                    <p>
                                        {!!  $product->description !!}
                                    </p>
                                    <div class="single-product-tables">

                                        <table>
                                            <tbody>
                                            @foreach($product->attributes as $attribute)
                                                <tr>
                                                    <td>
                                                        @if(isset($attribute->parentRow))
                                                            {{ $attribute->parentRow->name }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $attribute->name }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                                    <div class="mt-4 text-center">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/BUWzX78Ye_8" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div> -->

                                    <div class="tab-pane fade" id="top-review" role="tabpanel" aria-labelledby="review-top-tab">

                                            @if(auth()->check() && !$product->userAlreadyReviewed)
                                                <form action="#" method="post" id="review_form">
                                                    <div class="form-row" class="theme-form">
                                                        <div class="col-md-12">
                                                            <div class="media">
                                                                <label>{{trans('review.rating')}}</label>
                                                                <div class="media-body ml-3">
                                                                    <div class="rating three-star" id="rating-body">
                                                                        <div id="rateYo"></div>
                                                                        <!-- <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                            <div class="col-md-12">
                                                                <label for="review">{{trans('review.title')}}</label>
                                                                <input type="text" class="form-control" name="title" id="review_title" required>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label for="review">{{trans('review.body')}}</label>
                                                                <textarea class="form-control" name="body" rows="6" id="review_body" required></textarea>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button class="btn btn-normal" type="submit" id="submit_review_btn">{{trans('review.submit')}}</button>
                                                            </div>

                                                    </div>
                                                </form>
                                            @endif
                                            <br><br>
                                            <ul class="comment-section">

                                                @foreach($product->reviews as $review)
                                                    <li>
                                                        <div class="media"><img src="/assets/images/avtar/1.jpg" alt="Generic placeholder image">
                                                            <div class="media-body">
                                                                <h6>{{ (isset($review->user)) ? $review->user->name : '' }} <span>( {{$review->created_at->diffForHumans()}} )</span></h6>
                                                                <p>
                                                                    <b>{{$review->review_title}}</b><br>
                                                                    {{$review->review}}
                                                                </p>
                                                            </div>
                                                        </div>

                                                    </li>
                                                @endforeach
                                            </ul>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="section-big-py-space ratio_asos">
        <div class="custom-container">
            <div class="row">
                <div class="col-12 product-related">
                    <h2>{{ __('words.related_products') }}</h2>
                </div>
            </div>
            <div class="row ">
                <div class="col-12 product">
                    <div class="product-slide no-arrow">

                        @foreach($related_products as $rproduct)
                            @include('modules.blocks.product_card', [
                                'product' => $rproduct
                            ])
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>





@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endsection
@section('script')
    <!--elevatezoom js-->
    <script src="{{asset('assets/js/jquery.elevatezoom.js')}}"></script>
    <!--review-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        $(function () {

            // init
            var $rateYo = $("#rateYo").rateYo(
                {
                    rating: 0,
                    starWidth: "15px",
                    fullStar: true
                }
            );

            // on click
            $("#review_form").on("submit", function (e) {
                e.preventDefault();
                var rating = $rateYo.rateYo("rating");
                var reviewTitle = $('#review_title').val();
                var reviewBody = $('#review_body').val();

                // ajax request to
                $.ajax({
                    // url
                    url: '{{route('web.products.rate')}}',
                    type: 'post',
                    // data
                    data: {
                        item_id:{{ $product->id }},
                        rate:rating,
                        review_title:reviewTitle,
                        review:reviewBody,
                        _token: "{{ csrf_token() }}"
                    },
                    // success
                    success: function(response){
                        $("#rateYo").rateYo.readOnly = true;
                        // rated success
                        if(response.status){
                            $.notify({
                                icon: 'fa fa-check',
                                title: 'Success!',
                                message: 'Item Rated'
                            },{
                                element: 'body',
                                position: null,
                                type: "info",
                                allow_dismiss: true,
                                newest_on_top: false,
                                showProgressbar: true,
                                placement: {
                                    from: "top",
                                    align: "right"
                                },
                                offset: 20,
                                spacing: 10,
                                z_index: 1031,
                                delay: 2000,
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },
                                icon_type: 'class',
                                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                                    '<span data-notify="icon"></span> ' +
                                    '<span data-notify="title">{1}</span> ' +
                                    '<span data-notify="message">{2}</span>' +
                                    '</div>'
                            });
                            setTimeout(function(){ location.reload();; }, 2000);


                        }
                    }
                });
            });

        });

    </script>
@endsection
