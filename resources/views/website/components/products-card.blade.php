@if($product)
    @if($product->is_active != 0)


<div class="product-item">
    <div class="item-inner">
      <div class="product-thumbnail">
              @if($product->offer_flag())
                <div class="icon-new-label new-left">
                  {{ $product->offer_flag() }}
                </div>
              @endif
        <!-- @if($product->discount_priority() != 0)
          <div class="icon-new-label new-left">
              {{ __('words.Best Discount') }}
              {{$product->discount_priority()}}
          </div>
        @else
          @if(isset($dsection))
          <div class="icon-new-label new-left">
              {{ __('words.Deal Section') }}
              {{$dsection->discount}}
          </div>
          @else
            @if($product->on_sale)
            <div class="icon-new-label new-left">
                {{ __('words.on_sale') }}
                {{$product->discount($product->id)}}
            </div>
            @endif

            @if($product->is_combo)
            <div class="icon-new-label new-left">
                {{ __('words.is_combo') }}
                {{$product->discount($product->id)}}
            </div>
            @endif
          @endif
        @endif -->

        @if($product->stock <= $product->minimum_stock && $product->is_combo==0 && $product->is_bundle==0)
          <div class="icon-new-label new-right">
          {{__('Product.Low Stock')}}
          </div>
        @endif

        <div class="pr-img-area"> <a title="{{ $product->name }}" href="{{ $product->url }}">
          <figure>
          @if($product->is_combo == 1)
            <img class="first-img" src="{{ image('product',$product->get_bundle_products_image($product->id)) }}" style="height: 208px;" alt="Product">
            <img class="hover-img" src="{{ image('product',$product->get_bundle_products_image($product->id)) }}" style="height: 208px;" alt="Product">
            @elseif($product->is_bundle == 1)
            <img class="first-img" src="{{ image('product',$product->bundle_image) }}" style="height: 208px;" alt="Product">
            <img class="hover-img" src="{{ image('product',$product->bundle_image) }}" style="height: 208px;" alt="Product">
            @else
            <img class="first-img" src="{{ url('image/product/'.$product->get_image($product->id)) }}" style="height: 208px;" alt="Product">
            <img class="hover-img" src="{{ $product->thumbnail_url }}" style="height: 208px;" alt="Product">
          @endif
          </figure>
          </a> </div>
        <div class="pr-info-area product-icon icon-inline">

            @csrf
            <input name="id" type="hidden" value="{{$product->id}}">
            <input name="name" type="hidden" value="{{$product->name}}">
            <input name="price" type="hidden" value="{{$product->product_price}}">

          <div class="pr-button">
            <div class="mt-button add_to_wishlist">

              @if (in_array($product->id,getWishListsProductsId()))

                <a href="javascript:void(0)" title="Remove From Wishlist" >
                  <i class="ti-heart cartActive" aria-hidden="true" productId="{{$product->id}}"></i>
                </a>
              @else

                <a href="javascript:void(0)" title="Add to Wishlist" >
                  <i class="ti-heart" aria-hidden="true" productId="{{$product->id}}"></i>
                </a>
              @endif



            </div>
            <div class="mt-button quick-view">
              <a
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->getFinalPriceAfterDiscountPriroty() }}"
                    data-before_price="{{ $product->getFinalOldPricePriroty() }}"
                    data-image="{{ $product->thumbnail_url }}"
                    data-description="{{ $product->description }}"
                    data-id="{{ $product->id }}"
                    data-url="{{ $product->url }}"
                    data-max="{{ $product->stock }}"
                    data-low="{{$product->minimum_stock}}"
                    data-reviews="{{intval($product->scopeReviewsDetails()[0]['rateAvg'])}}"
                    href="#"
                    class="quick-view-btn"
                    title="Quick View">
                    <i class="ti-search" aria-hidden="true"></i>
                </a>
            </div>
            <div class="mt-button add_to_compare" data-productid="{{$product->id}}">
                <a href="javascript:void(0)" title="Add to Compare" >
                  <i class="ti-layout-grid2" aria-hidden="true" productId="{{$product->id}}"></i>
                </a>
            </div>
          </div>
        </div>
      </div>
      <div class="item-info">
        <div class="info-inner">
          <div class="item-title"> <a title="{{ $product->name }}" href="{{ $product->url }}">{{ $product->name }} </a> </div>
          <div class="item-content">
            <div class="rating">
              @include('website.products.rating-template',[
                'avg'=>$product->getRateAvg()
              ])
            </div>
            <div class="item-price">
              <div class="price-box"> <span class="regular-price"> <span class="price">

                  @if($product->is_offer())
                    @if (!has_cupon($product->id) )
                    <span style="text-decoration:line-through; color:grey"> {{ $product->getFinalOldPricePriroty() }} {{__('product.currency')}}</span>
                    @endif
                    {{ $product->getFinalPriceAfterDiscountPriroty() }} {{__('product.currency')}}
                  @else
                  {{ $product->price }}  {{__('product.currency')}}
                  @endif


                </div>
            </div>
            <div class="add-to-cart-product mt-5">

                  @if($product->stock > 0)
  
                   @if($product->is_bundle == 1 )
                      @php
                        $BundleItemsStock=$product->checkBundleItemsStock($product->id);
                      @endphp

                      @if( $BundleItemsStock['status'] =="fail")
                      <button class="website_addtocart btn btn-normal w-100" style="padding: 4px 8px; color:#000 !important; background-color:#fff !important;" >
                            <i></i> {{__('Product.Out Of Stock')}}
                        </button>
                      @else
                      <button class="website_addtocart btn btn-normal w-100" style="padding: 4px 8px" productId="{{$product->id}}" qty="1"  price="{{$product->getFinalPriceAfterDiscountPriroty()}}"  discount="{{$product->getFinalDiscountPriroty()}}">
                          <i></i> {{__('User.Add To Cart')}} 
                      </button>
                      @endif
                    @else   
                    <button class="website_addtocart btn btn-normal w-100" style="padding: 4px 8px" productId="{{$product->id}}" qty="1"  price="{{$product->getFinalPriceAfterDiscountPriroty()}}"  discount="{{$product->getFinalDiscountPriroty()}}">
                        <i></i> {{__('User.Add To Cart')}}
                    </button>
                    @endif
 
                  @else
                  <button class="btn btn-normal w-100" style="padding: 4px 8px; color:#000 !important; background-color:#fff !important;" >
                    
                        <i></i> {{__('Product.Out Of Stock')}}
                    </button>

                  @endif

          </div>
          </div>
        </div>
      </div>
    </div>
</div>
    @else
        there are no products available
    @endif

@endif

