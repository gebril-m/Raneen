@if($product)
<div>
    <div class="product-box">
        <div class="product-imgbox">
            <div class="product-front">
                <img src="{{ $product->thumbnail_url }}" class="img-fluid  " alt="product">
            </div>

            <div class="product-icon icon-inline">
                    @csrf
                    <input name="id" type="hidden" value="{{$product->id}}">
                    <input name="name" type="hidden" value="{{$product->name}}">
                    <input name="price" type="hidden" value="{{$product->product_price}}">
                    <button class="addToCartFromCardComponent" productId="{{$product->id}}">
                        <i class="ti-bag" productId="{{$product->id}}"></i>
                    </button>
                <a href="javascript:void(0)" title="Add to Wishlist" >
                    <i class="ti-heart" aria-hidden="true" productId="{{$product->id}}"></i>
                </a>
                <a
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->product_price }}"
                    data-image="{{ $product->thumbnail_url }}"
                    data-description="{{ $product->description }}"
                    data-id="{{ $product->id }}"
                    data-url="{{ $product->url }}"
                    data-max="{{ $product->stock }}"
                    href="#"
                    class="quick-view-btn"
                    title="Quick View">
                    <i class="ti-search" aria-hidden="true"></i>
                </a>

            </div>
            
            @if($product->on_sale)
                <div class="on-sale1">
                    {{ __('words.on_sale') }}
                </div>
            @endif
        </div>
        <div class="product-detail detail-inline ">
            <div class="detail-title">
                <div class="detail-left">
                    <div class="rating-star d-flex justify-content-center">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <a href="{{ $product->url }}">
                        <h6 class="price-title">{{ $product->name }}</h6>
                    </a>
                </div>
                <div class="detail-right">
                    @if($product->product_before_price)
                        <div class="check-price">
                            $ {{ $product->product_before_price }}
                        </div>
                    @endif
                    <div class="price">
                        <div class="price">
                            $ {{ $product->product_price }}
                        </div>
                    </div>
                </div>
                <div class="add-to-cart-product mt-5">
                    <button class="addToCartFromCardComponent btn btn-normal w-100" productId="{{$product->id}}">
                        <i class="ti-bag" productId="{{$product->id}}"></i> Add To Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
