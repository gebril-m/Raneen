@extends('website.layouts.master')

@section('title',$product->name)

@section('stylesheet')

@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')

  <div class="main-container col1-layout">
    <div class="container">
      <div class="row">
        <div class="col-main">
          @if($product)
          @php
            if($product->is_bundle == 1){
              $images = $product->get_my_bundle_images($product->id);
              $mainImg=$images[0];
            }else{
              $images = $product->images;
              $mainImg=$images[0]['image'];
            }

          @endphp
          <div class="product-view-area">
            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
              <!-- <div class="icon-sale-label sale-left">Sale</div> -->
              @if(count($images) > 0)
              <div class="large-image">
              <a href="<?php if($product->is_bundle==1)$product->bundle_image; else image('product',$images[0]);?>" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20" style="position: relative; display: block;">

              <img class="zoom-img" src="{{ image('product',$mainImg) }}" alt="products" style="display: block; visibility: visible;"> </a> </div>
              @endif
              <div class="flexslider flexslider-thumb">

              <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="previews-list slides" style="width: 1000%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                  @php $counter = 1 ;
                  @endphp


                  @foreach($images as $img)
                   @php
                    if($product->is_bundle==1){
                        $imgPath= $img;
                    }else{
                        $imgPath=$img->image;
                    }
                    @endphp
                  <li style="width: 100px; float: left; display: block;">
                  <a href="{{ image('product', $imgPath)  }}" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '{{ image('product', $imgPath)  }}' ">
                    <img src="{{ thumb('product', 150, 150, $imgPath)  }}" alt="Thumbnail 2" draggable="false">
                  </a>
                </li>
                      @php $counter = $counter+ 1 ;@endphp
                  @endforeach
                </ul></div><ul class="flex-direction-nav"><li><a class="flex-prev flex-disabled" href="#" tabindex="-1"></a></li><li><a class="flex-next" href="#"></a></li></ul></div>

              <!-- end: more-images -->

            </div>
            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area">
              <div class="product-name">
                <h1>{{$product->name}}</h1>
              </div>
              <div class="price-box">
                <p class="special-price"> <span class="price-label"><!-- Special Price --></span> <span style="font-size: 28px;color: #e74c3c;font-weight: 600;"><span>{{$product->getFinalPriceAfterDiscountPriroty()}} {{__('product.currency')}}</span> </span> </p>

                <!-- Shipping Cost -->
                <!-- <p class="shipping-price"> <span class="price-label"></span> <span class="price"> $<span>{{ $product->get_category()->shipping_value }}</span> </span> </p> -->

                @if($product->is_offer())
                <p class="old-price"> <span class="price-label">{{__('Product.Regular Price')}}:</span> <span class="price"> {{$product->getFinalOldPricePriroty()}} {{__('product.currency')}}</span> </p>
                @endif
                @if($combo > 0)
                <h3 class="bundle-price "  style="display: none ;">{{trans('bundle.price')}}:
                  <span class="before" style="display: none; text-decoration: line-through; color:grey">{{$product->product_price}}</span>
                  <span class="after" style="display: none ;color:red">{{$product->product_price}}</span>

                </h3>
                @endif
              </div>
              <div class="ratings">
                <div class="rating">
                  @include('website.products.rating-template',[
                    'avg'=>$product->getRateAvg()
                  ])
                </div>
                <!-- <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Your Review</a> </p> -->
                @if($product->is_bundle == 0 && $product->is_combo == 0)
                  @if($product->stock > 0)
                    @if($product->stock <= $product->minimum_stock)
                      <p class="availability low-stock p-r">{{__('Product.Availability')}}: <span>{{__('Product.Low Stock')}}</span></p>
                    @else
                      <p class="availability in-stock p-r">{{__('Product.Availability')}}: <span>{{ $product->stock }} {{__('Product.In Stock')}}</span></p>
                    @endif
                  @else
                  <p class="availability out-of-stock p-r">{{__('Product.Availability')}}: <span>{{__('Product.Out Of Stock')}}</span></p>
                  @endif

                @endif
              </div>
              <div class="attributes-btns">
                @php $groups = []; @endphp
                @foreach($product->attributes as $attribute)
                    @if(isset($attribute->parentRow))
                      @if(!in_array($attribute->parentRow->id,$groups))
                      @php array_push($groups,$attribute->parentRow->id); @endphp
                        </div><div class="attributes-btns" style="    margin: 15px 0;">
                        <h4>{{ $attribute->parentRow->name }}</h4>
                        @php $i=0 @endphp
                        @foreach($product->get_attrs_child($attribute->parentRow->id,$product->attributes) as $attr)
                        @php $i++ @endphp
                        <button class="button attribute-btn btn-normal @if($i==1) active @endif" data-id="{{$attr->id}}" data-price="{{$attr->product($product->id,$attr->id)->price}}" data-picture="@if($attr->product($product->id,$attr->id)->picture) {{image('product',$attr->product($product->id,$attr->id)->picture)}} @endif">{{ $attr->name }}</button>
                        @endforeach
                      @endif

                    @endif
                @endforeach
              </div>
              <div class="product-color-size-area" style="display: none">
                <div class="color-area">
                  <h2 class="saider-bar-title  cole" style="padding: 15px;">{{__('Product.Color')}}</h2>
                  <div class="color content">
                    @if(isset($attrs['color']))
                        <ul>
                            @foreach($attrs['color'] as $k => $attr)
                                @if($attr['quantity'] > 0)
                                    <li data-qty="{{ array_sum($attr['quantity']) }}" date-color="{{$k}}" style="background:{{$k}}; width:25px; height: 25px" @if($loop->index == 0) class="active" @endif ></li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                  </div>
                </div>
                <!-- <div class="size-area">
                  <h2 class="saider-bar-title">Size</h2>
                  <div class="size">
                    <ul>
                      <li><a href="#">S</a></li>
                      <li><a href="#">L</a></li>
                      <li><a href="#">M</a></li>
                      <li><a href="#">XL</a></li>
                      <li><a href="#">XXL</a></li>
                    </ul>
                  </div>
                </div> -->
              </div>

                  @if($product->stock > 0)

                  @if($product->is_bundle == 1 )
                    @php
                    $BundleItemsStock=$product->checkBundleItemsStock($product->id);  
                    @endphp

                    @if( $BundleItemsStock['status'] =="fail") 
                       
                      <p class="availability out-of-stock p-r">{{__('Product.Availability')}}: <span>{{__('Product.Out Of Stock')}}</span></p>
                    @else
                    <input type="hidden" id="productBundleStock" value="{{ $BundleItemsStock['productBundleStock'] }}" >
                    <div class="cart-plus-minus">
                    <label for="qty">{{__('Product.Quantity')}}:</label>
                    <div class="numbers-row">
                      <div onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                      <input type="text" class="qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                      <div onclick="var product_qty=document.getElementById('productBundleStock').value; var result = document.getElementById('qty'); var qty = result.value;  if( !isNaN( qty ) &amp;&amp; (qty >= 1 && qty <= parseInt(product_qty) - 1)) result.value++;return false; " class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                    </div>
                  </div>
                  <button class="button pro-add-to-cart website_addtocart" style="padding: 4px 8px"title="Add to Cart" type="button" productId="{{$bundle}}" data-price="{{$product->getFinalPriceAfterDiscountPriroty()}}"><span><i class="fa fa-shopping-basket" productId="{{$product->id}}" data-price="{{$product->getFinalPriceAfterDiscountPriroty()}}"></i> {{__('Home.ADD TO CART')}}</span></button>
                  
                    @endif

                  @else   
                  <div class="cart-plus-minus">
                    <label for="qty">{{__('Product.Quantity')}}:</label>
                    <div class="numbers-row">
                      <div onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                      <input type="text" class="qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                      <div onclick="var product_qty=document.getElementById('product_qty').value; var result = document.getElementById('qty'); var qty = result.value;  if( !isNaN( qty ) &amp;&amp; (qty >= 1 && qty <= parseInt(product_qty) - 1)) result.value++;return false; " class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                    </div>
                  </div>
                  <button class="button pro-add-to-cart website_addtocart" style="padding: 4px 8px"title="Add to Cart" type="button" productId="{{$product->id}}" data-price="{{$product->getFinalPriceAfterDiscountPriroty()}}" ><span><i class="fa fa-shopping-basket" productId="{{$product->id}}"></i> {{__('Home.ADD TO CART')}}</span></button>

                  
                  @endif

                   <input type="hidden" id="product_qty" value="{{ $product->stock }}" >
              <div class="product-variation" >
                  
              </div>

                  @endif

              <div class="product-cart-option">
                <input name="id" type="hidden" value="{{$product->id}}">
                <input name="name" type="hidden" value="{{$product->name}}">
                <input name="original_price" type="hidden" value="{{$product->product_price}}">
                <input name="price" type="hidden" value="{{$product->product_price}}">
                <ul>
                  <li class="add_to_wishlist"><div data-productId="{{$product->id}}" productId="{{$product->id}}"><i class="fa fa-heart-o ti-heart" productId="{{$product->id}}"></i><span class="title-font" productId="{{$product->id}}">{{trans('home.Add To WishList')}}</span></div></li>
                  <li class="add_to_compare" data-productId="{{$product->id}}"><i class="ti-layout-grid2"></i><span> {{__('Product.Add to Compare')}}</span></li>
                  <!-- <li><a href="#"><i class="fa fa-envelope"></i><span>Email to a Friend</span></a></li> -->
                </ul>
              </div>
              <!-- <div class="pro-tags">
                <div class="pro-tags-title">Tags:</div>
                <a href="#">ecommerce</a>, <a href="#">bootstrap</a>, <a href="#">shopping</a>, <a href="#">fashion</a>, <a href="#">responsive</a> </div> -->
              <div class="share-box">
                <div class="title">Share in social media</div>
                <div class="socials-box"> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-google-plus"></i></a> <a href="#"><i class="fa fa-youtube"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> <a href="#"><i class="fa fa-instagram"></i></a> </div>
              </div>
              @if($combo > 0)
              <div class="row bunndel">
                <div class="col-xs-12">
                    <h4 style="margin-top: 5px;">{{__('Combo.Frequently Bought Together')}}</h4>
                    @if(count($product->get_bundle_products($combo)) > 0)
                    @php $i=0 @endphp
                      @foreach($product->get_bundle_products($combo) as $combo_p)
                      @php $i++ @endphp
                      @if($i>2)
                      <div class="col-xs-1" style="padding: 35px 0 0 0 ;font-size: 30px;font-weight: 600; text-align: center;">+</div>
                      @endif
                      @if($i>1)
                      <div class="col-xs-2" style="border: 1px solid #eeeeee ;margin-bottom: 5px;padding: 5px;">
                        <a href="{{$combo_p->url}}">
                          <img src="{{ image('product',$combo_p->images[0]->image) }}">
                          <div style="text-align: center;font-size: 15px;">{{$combo_p->name}}
                        </a>
                      </div>
                      </div>
                      @endif
                      @endforeach
                    @endif
                </div>


                @if(count($product->get_bundle_products($combo)) > 0)
                  @php $i=0 @endphp
                  @foreach($product->get_bundle_products($combo) as $combo_p)
                  @php $i++ @endphp
                  @if($i>1)
                  <div class="col-xs-12">
                      <input type="checkbox" class="combo_inputs" productid="{{$combo_p->id}}" data-discount="{{$combo_p->get_discount_bundle_product($combo,$combo_p->id)[0]}}" data-price="{{$combo_p->get_discount_bundle_product($combo,$combo_p->id)[1]}}" data-priceafter="{{$combo_p->get_discount_bundle_product($combo,$combo_p->id)[2]}}">
                      <!-- <span>{{__('Combo.Buy Item')}}</span> -->
                      <label style="padding: 4px ; font-size:18px;color:black">إضافة  <span style="color: grey;">{{$combo_p->name}}</span> <span class="price_product" style="color: #b22827;"><s>$ {{$combo_p->price}}</s></span>
                      </label>
                  </div>
                  @endif
                  @endforeach
                @endif
                <div class="col-xs-12">
                    <button class="button pro-add-to-cart combo_add_cart" title="Add to Cart" type="button" data-combo="{{$combo}}"><span><i class="fa fa-shopping-basket"></i>{{__('Combo.Buy Products')}}</span></button>
                </div>
              </div>
              @endif
              @if($bundle > 0)
              <div class="row bunndel">
                <div class="col-xs-12">
                    <h4 style="margin-top: 5px;">{{__('Combo.Frequently Bought Together')}}</h4>
                    @if(count($product->get_bundle_products($bundle)) > 0)
                    @php $i=0 @endphp
                      @foreach($product->get_bundle_products($bundle) as $bundle_p)
                      @php $i++ @endphp
                      @if($i>1)
                      <div class="col-xs-1" style="padding: 35px 0 0 0 ;font-size: 30px;font-weight: 600; text-align: center;">+</div>
                      @endif
                      <div class="col-xs-2" style="border: 1px solid #eeeeee ;margin-bottom: 5px;padding: 5px;">
                        <a href="{{$bundle_p->url}}">
                          <img src="{{ image('product',$bundle_p->images[0]->image) }}">
                          <div style="text-align: center;font-size: 15px;">{{$bundle_p->name}}</div>
                        </a>
                      </div>
                      @endforeach
                    @endif
                </div>


                @if(count($product->get_bundle_products($combo)) > 0)
                  @php $i=0 @endphp
                  @foreach($product->get_bundle_products($combo) as $combo_p)
                  @php $i++ @endphp
                  @if($i>1)
                  <div class="col-xs-12">
                      <!-- <span>{{__('Combo.Buy Item')}}</span> -->
                      <label  > <span>{{$combo_p->name}}</span> <span class="price_product"><s>$ {{$combo_p->price}}</s></span>
                      </label>
                  </div>
                  @endif
                  @endforeach
                @endif
                @if($combo > 0)
                <div class="col-xs-12">
                    <button class="button pro-add-to-cart combo_add_cart" title="Add to Cart" type="button"><span><i class="fa fa-shopping-basket"></i>{{__('Combo.Buy Products')}}</span></button>
                </div>
                @endif
              </div>
              @endif

            </div>
          </div>
          @endif
        </div>
        <div class="product-overview-tab">
          <div class="container">
            <div class="row">
              <div class="col-xs-12">
                <div class="product-tab-inner">
                  <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                    <li class="active"> <a href="#description" data-toggle="tab"> {{__('Product.Description')}} </a> </li>
                    <li> <a href="#reviews" data-toggle="tab">{{__('Product.Reviews')}}</a> </li>
                    <!-- <li><a href="#product_tags" data-toggle="tab">Tags</a></li>
                    <li> <a href="#custom_tabs" data-toggle="tab">Custom Tab</a> </li> -->
                  </ul>
                  <div id="productTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="description">
                      <p>
                          {!!  $product->description !!}
                      </p>
                      <div class="single-product-tables">

                          {{--<table>
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
                          </table>--}}
                      </div>
                    </div>
                    <div id="reviews" class="tab-pane fade">

                    <div class="col-sm-12 col-lg-12 col-md-12">
                        <div class="reviews-content-left">
                          <div class="rating col-xs-12" style="padding: 30px 0; background-color: #b22827; margin-bottom: 5px;">
                            <span class="rating-num">
                            {{intval($product->scopeReviewsDetails()[0]['ratesCount'])}}
                              <!-- {{intval($product->scopeReviewsDetails()[0]['rateAvg'])}} -->
                            </span>

                            <div class="rating-stars" style="display: block;">
                              <div class="rating-stars">
                                @include('website.products.rating-template',[
                                  'avg'=>$product->getRateAvg()
                                ])
                              </div>
                            </div>
                            <div class="rating-users">
                              <i class="icon-user"></i> {{intval($product->scopeReviewsDetails()[0]['ratesCount'])}} {{__('Review.Total')}}
                            </div>
                          </div>
                          <h2>{{__('Product.Reviews')}}</h2>
                          @foreach($product_reviews as $review)
                          <div class="review-ratting col-xs-6">
                            <p class="author" style="color: #b22827;font-size: 16px;"> {{ (isset($review->user)) ? $review->user->name : '' }}<span style="color: #999999; font-size: 12px;"> ({{__('Review.Posted On')}} {{$review->created_at}})</span> </p>
                            <P style="color: #333333;">{{$review->review_title}}</P>
                            <p style="color: gray;">{{$review->review}}</p>
                             <span ><div class="rating">
                              @include('website.products.rating-template',[
                                'avg'=>intval($review->rate)
                              ])
                            </div></span>
                          </div>
                          @endforeach

                          <!-- <div class="buttons-set">
                            <button class="button submit" title="Submit Review" type="submit"><span><i class="fa fa-angle-double-right"></i> &nbsp;view all</span></button>
                          </div> -->
                        </div>
                      </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="tab-pane fade" id="product_tags">
                      <div class="box-collateral box-tags">
                        <div class="tags">
                          <!-- Fourth Tab -->
                        </div>
                        <!--tags-->
                        <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom_tabs">
                      <div class="product-tabs-content-inner clearfix">
                        TAB
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

<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-12 jtv-best-sale special-pro related_products_product">
      <div class="jtv-best-sale-list">
          <div class="wpb_wrapper">
              <div class="best-title text-left">
                  <h2>{{__('Product.Related Products')}}</h2>
              </div>
          </div>
          <div class="featured-pro">
            <div class="slider-items-products">
              <div id="computer-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4">

                  @foreach($related_products as $rproduct)
                      @include('website.components.products-card', [
                          'product' => $rproduct
                      ])
                  @endforeach
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>



@include('website.components.footer')





@endsection

@section('javascript')

@endsection
