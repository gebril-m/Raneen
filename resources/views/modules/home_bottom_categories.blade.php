@if($content)

    @php
        $catsDb = \App\Category::whereIn('id', [
            $content->first_category,
            $content->second_category,
            $content->third_category,
        ])->get()->pluck([], 'id');

        $brandsDb = \App\Brand::whereIn('id', [
            $content->first_brand,
            $content->second_brand,
            $content->third_brand,
        ])->get()->pluck([], 'id');

    @endphp

    <!--collection banner start-->
    <section class="collection-banner section-py-space">
        <div class="container-fluid">
            <div class="row collection2">
                <div class="col-md-4">
                    <div class="collection-banner-main banner-1  p-right">
                        <div class="collection-img">
                            @if(isset($content->first_image))
                                <img src="{{ image('module', $content->first_image) }}" class="img-fluid bg-img  ">
                            @endif
                        </div>
                        <div class="collection-banner-contain">
                            <div class="custom-banner">
                                @if(isset($catsDb->get($content->first_category)->name))
                                <h3>{{ $catsDb->get($content->first_category)->name }}</h3>
                                @endif
                                @if(isset($brandsDb->get($content->first_brand)->name))
                                <h3>{{ $brandsDb->get($content->first_brand)->name }}</h3>
                                @endif
                                <div class="shop">
                                    @if(isset($catsDb->get($content->first_category)->url))
                                    <a href="{{ $catsDb->get($content->first_category)->url }}">
                                        {{ __('words.shop_now') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="collection-banner-main banner-1 p-right">
                        <div class="collection-img">
                            @if(isset($content->second_image))
                                <img src="{{ image('module', $content->second_image) }}" class="img-fluid bg-img  " >
                            @endif
                        </div>
                        <div class="collection-banner-contain ">
                            <div class="custom-banner">
                                @if(isset($catsDb->get($content->second_category)->name))
                                <h3>{{ $catsDb->get($content->second_category)->name }}</h3>
                                @endif
                                @if(isset($brandsDb->get($content->second_brand)->name))
                                <h3>{{ $brandsDb->get($content->second_brand)->name }}</h3>
                                @endif
                                <div class="shop">
                                    @if(isset($catsDb->get($content->second_category)->url))
                                    <a href="{{ $catsDb->get($content->second_category)->url }}">
                                        {{ __('words.shop_now') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="collection-banner-main banner-1 p-right">
                        <div class="collection-img">
                            @if(isset($content->third_image))
                                <img src="{{ image('module', $content->third_image) }}" class="img-fluid bg-img  " >
                            @endif
                        </div>
                        <div class="collection-banner-contain ">
                            <div class="custom-banner">
                                @if(isset($catsDb->get($content->third_category)->name))
                                <h3>{{ $catsDb->get($content->third_category)->name }}</h3>
                                @endif
                                @if(isset($brandsDb->get($content->third_brand)->name))
                                <h3>{{ $brandsDb->get($content->third_brand)->name }}</h3>
                                @endif
                                <div class="shop">
                                    @if(isset($catsDb->get($content->third_category)->url))
                                    <a href="{{ $catsDb->get($content->third_category)->url }}">
                                        {{ __('words.shop_now') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--collection banner end-->
@endif
