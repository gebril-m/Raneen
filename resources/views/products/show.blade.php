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
                            <h2>{{trans('home.product')}}</h2>
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


<section class="bg-light showpage" style="margin-top: 50px;">
    <div class="collection-wrapper">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-1 col-sm-2 col-xs-12">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="slider-right-nav">
                                <div><img src="{{ $product->thumbnail }}" alt="" class="img-fluid  image_zoom_cls-0"></div>
                                <div><img src="{{ $product->thumbnail }}" alt="" class="img-fluid  image_zoom_cls-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-10 col-xs-12 order-up">
                    <div class="product-right-slick no-arrow">
                        <div><img src="{{ $product->thumbnail }}" alt="" class="img-fluid  image_zoom_cls-0"></div>
                    </div>
                </div>
                <div class="col-lg-7 rtl-text">
                    <div class="product-right">
                        <h2>{{$product->name}}</h2>
                        <!-- <h4><del>$459.00</del><span>55% off</span></h4> -->
                        <h3>$ {{ $product->price }}</h3>
                        <ul class="color-variant">
                            @foreach($attrs['color'] as $k => $attr)
                                <li style="background:{{$k}}" ></li>
                            @endforeach
                        </ul>
                        <div class="product-description border-product">
{{--                            <h6 class="product-title size-text">select size <span><a href="" data-toggle="modal" data-target="#sizemodal">size chart</a></span></h6>--}}

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

                            <h6 class="product-title">quantity</h6>
                            <div class="qty-box">
                                <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                    <input type="text" name="quantity" max="{{ $product->stock }}" class="form-control input-number" value="1">
                                    <span class="input-group-prepend">
                                        <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                                            <i class="ti-angle-right"></i>
                                        </button>
                                    </span></div>
                                </div>
                            </div>
                        <div class="product-buttons">

                                <input name="id" type="hidden" value="{{$product->id}}">
                                <input name="name" type="hidden" value="{{$product->name}}">
                                <input name="price" type="hidden" value="{{$product->price}}">
                                <button class="btn btn-normal addToCart" type="submit" style="padding:13px" productId="{{$product->id}}">
                                    add to cart
                                </button>

                            <a href="javascript:void(0)" class="btn btn-normal">
                                buy now
                            </a>
                        </div>
                        <div class="border-product">
                            <h6 class="product-title">product details</h6>
                            <p>
                                {!! $product->description !!}
                            </p>
                        </div>
                        <div class="border-product">
                            <div class="product-icon">
                                <ul class="product-social">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                </ul>

                                <input name="id" type="hidden" value="{{$product->id}}">
                                <input name="name" type="hidden" value="{{$product->name}}">
                                <input name="price" type="hidden" value="{{$product->price}}">
                                <button class="wishlist-btn" productId="{{$product->id}}">
                                    <i class="fa fa-heart" productId="{{$product->id}}"></i>
                                    <span class="title-font" productId="{{$product->id}}">Add To WishList</span>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class=" tab-product tab-exes">
    <div class="custom-container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="creative-card creative-inner">
                    <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-selected="true">Description</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-toggle="tab" href="#top-profile" role="tab" aria-selected="false">Details</a>
                            <div class="material-border"></div>
                        </li>
{{--
                        <li class="nav-item"><a class="nav-link" id="review-top-tab" data-toggle="tab" href="#top-review" role="tab" aria-selected="false">Write Review</a>
                            <div class="material-border"></div>
                        </li>
--}}
                    </ul>
                    <div class="tab-content nav-material" id="top-tabContent">

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
                            <form class="theme-form">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="media">
                                            <label>Rating</label>
                                            <div class="media-body ml-3">
                                                <div class="rating three-star"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter Your name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="Email" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="review">Review Title</label>
                                        <input type="text" class="form-control" id="review" placeholder="Enter your Review Subjects" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="review">Review Title</label>
                                        <textarea class="form-control" placeholder="Wrire Your Testimonial Here" id="exampleFormControlTextarea1" rows="6"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-normal" type="submit">Submit Your Review</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-big-py-space  ratio_asos bg-light">
    <div class="custom-container">
        <div class="row">
            <div class="col-12 product-related">
                <h2>{{ __('words.related_products') }}</h2>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 product">
                <div class="product-slide no-arrow">

                    @foreach($related_products as $product)
                        @include('modules.blocks.product_card', [
                            'product' => $product
                        ])
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>


@endsection
