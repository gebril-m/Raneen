@if($content)
<!--slider start-->

<section class="theme-slider b-g-white " id="theme-slider">
    <div class="custom-container">
        <div class="row">
            <div class="col-xl-2 padding-0">
                <section class="app">
                    @include('layouts.component._sidbar')
                </section>
            </div>
            <div class="col-lg-12 col-xl-10">
                <div class="slide-1 no-arrow show-slider">
                    @foreach($content->slide as $data)
                    @php
                        $index = $loop->index + 1;
                        $product = isset($data->product) ? \App\Product::find($data->product) : null;
                        if (!$product) continue;
                    @endphp
                    <div>
                        <div class="slider-banner p-center slide-banner-1">
                            <div class="slider-img">
                                @if(isset($product))
                                <a href="{{ $product ? $product->url : '' }}" class="slider-link">
                                    <img src="{{ image('module', $data->image) }}" class="img-fluid" alt="{{ $data->first_title->{$locale} }}">
                                </a>
                                <a href="{{ $product ? $product->url : '' }}" class="overlay-label">{{ $product->name }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @php
                $left_top_product = \App\Product::find($content->left_top_product);
                $left_bottom_product = \App\Product::find($content->left_bottom_product);
            @endphp
            {{-- <div class="col-xl-3">
                <div class="adAside">
                    <a href="{{ $left_top_product->url }}" class="adAside_link">
                        <img src="{{ image('module', $content->left_top_image) }}" alt="" class="img-fluid">
                    </a>
                </div>
                <div class="adAside">
                    <a href="{{ $left_bottom_product->url }}" class="adAside_link">
                        <img src="{{ image('module', $content->left_bottom_image) }}" alt="" class="img-fluid">
                    </a>
                </div>
            </div> --}}
        </div>
    </div>

</section>
<!--slider end-->
@endif
