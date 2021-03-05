<div>
    <div class="media-banner media-banner-1 border-0">
        @foreach($products as $product)
            <div class="media-banner-box">
                <div class="media">
                    <a href="{{ $product->url }}"><img src="{{ $product->thumbnail_url }}" width="110" height="140" class="img-fluid" alt="banner" style="height: 140px !important; width: 110px;"></a>
                    <div class="media-body">
                        <div class="media-contant">
                            <div>
                                <div class="rating">
                                    <i class="fa fa-star" ></i>
                                    <i class="fa fa-star" ></i>
                                    <i class="fa fa-star" ></i>
                                    <i class="fa fa-star" ></i>
                                    <i class="fa fa-star" ></i>
                                </div>
                                <p>
                                    <a href="{{ $product->url }}">{{ $product->name }}</a>
                                </p>
                                <h6>${{ $product->price }}
                                @if($product->on_sale)
                                    <span>${{ $product->sale_price }} </span>
                                @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
