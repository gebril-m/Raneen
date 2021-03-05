@if($content)

    <section class="collection-banner ">
        <div class="custom-container">
            <div class="row layout-6-collection">
                @foreach(['left', 'right'] as $side)
                @php
                    $obj = null;
                    if($content->{'type_' . $side} == 'product') {
                        $obj = \App\Product::where('id', $content->{'product_' . $side})
                            ->where('is_active', true)
                            ->where('stock', '>', 0)
                            ->first();
                    } else if($content->{'type_' . $side} == 'category') {
                        $obj = \App\Category::where('id', $content->{'category_' . $side})->first();
                    }
                @endphp
                <div class="col-md-6  ">
                    <div class="collection-banner-main p-left  height-equal" style="min-height: 235px;">
                        <div class="collection-img bg-size" style="background-image: url(&quot;../assets/images/layout-4/collection-banner/1.jpg&quot;); background-size: cover; background-position: center center; display: block;">
                            @if(isset($obj->thumbnail_url))
                            <img src="{{ $obj->thumbnail_url }}" class="img-fluid bg-img  " alt="banner" style="display: none;">
                            @endif
                        </div>
                        <div class="collection-banner-contain">
                            <div>
                                @if(isset($obj->name))
                                <h3>{{ $obj->name }}</h3>
                                @endif
                                <div class="shop">
                                    @if(isset($obj->url))
                                    <a href="{{ $obj->url }}">
                                        {{ __('module.shop_now') }}
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
@endif
