@if($product)
@if(isset($product->get_product($product->product_id)->url))
<div class="product-item">
    <div class="item-inner">
        
      <div class="product-thumbnail">
        
        @if($product->on_sale)
        <div class="icon-new-label new-left">
            {{ __('words.on_sale') }}
        </div>
        @endif

        @if($product->is_combo)
        <div class="icon-new-label new-left">
            {{ __('words.is_combo') }} 
            {{$product->discount($product->id)}} 
        </div>
        @endif
        
        @if($product->stock <= $product->minimum_stock)
          <div class="icon-new-label new-right">
          {{__('Product.Low Stock')}}
          </div> 
        @endif
        <div class="pr-img-area"> <a title="{{ $product->name }}" href="{{ $product->get_product($product->product_id)->url }}">
          <figure> <img class="first-img" src="{{ $product->get_images()[0] }}" alt="Product"> <img class="hover-img" src="{{ $product->get_product($product->product_id)->thumbnail_url }}" alt="Product"></figure>
          </a> </div>
        <div class="pr-info-area product-icon icon-inline">

            @csrf
            <input name="id" type="hidden" value="{{$product->id}}">
            <input name="name" type="hidden" value="{{$product->name}}">
            <input name="price" type="hidden" value="{{$product->get_product($product->product_id)->price}}">

          <div class="pr-button">
            <div class="mt-button add_to_wishlist">

              @if (in_array($product->id,getWishListsProductsId()))
                
                <a href="javascript:void(0)" title="Remove From Wishlist" >
                  <i class="ti-heart cartActive" aria-hidden="true" productId="{{$product->product_id}}"></i>
                </a>
              @else
                
                <a href="javascript:void(0)" title="Add to Wishlist" >
                  <i class="ti-heart" aria-hidden="true" productId="{{$product->product_id}}"></i>
                </a>
              @endif

              
              
            </div>
            <div class="mt-button quick-view"> 
              <a
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->get_product($product->product_id)->price }}"
                    data-image="{{ $product->get_product($product->product_id)->thumbnail_url }}"
                    data-description="{{ $product->description }}"
                    data-id="{{ $product->id }}"
                    data-url="{{ $product->get_product($product->product_id)->url }}"
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
                'avg'=>intval($product->scopeReviewsDetails()[0]['rateAvg'])
              ])
            </div>
            <div class="item-price">
              <div class="price-box"> <span class="regular-price"> <span class="price">
                 @if($product->is_offer())
                    <span style="text-decoration:line-through; color:grey"> {{ $product->getFinalOldPricePriroty() }} {{__('product.currency')}}</span>
                    {{ $product->getFinalPriceAfterDiscountPriroty() }}{{__('product.currency')}}
                  @else
                   {{ $product->price }}{{__('product.currency')}}
                  @endif  
              </div>
            </div>
              
            <div class="pro-action">
               @if($product->is_bundle == 0 && $product->is_combo == 0)
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
                  <button class="website_addtocart btn btn-normal w-100" style="padding: 4px 8px; color:#000 !important; background-color:#fff !important;" >
                        <i></i> {{__('Product.Out Of Stock')}}
                    </button>
                    
                  @endif
                @endif
              
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endif
@endif

