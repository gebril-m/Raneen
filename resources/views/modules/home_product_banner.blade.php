@if($content)
    <!--collection banner start-->
    <section class="collection-banner section-pb-space ">
        <div class="custom-container">
            <div class="row">
                <div class="col">
                    <div class="collection-banner-main banner-5 p-center">
                        <div class="collection-img">
                            <img src="{{ image('module', $content->image) }}" class="bg-img  " alt="banner">
                        </div>
                        <div class="collection-banner-contain ">
                            <div class="sub-contain">
                                <h3>{{ $content->{'worda_' . $locale} }}</h3>
                                <h4>{{ $content->{'wordb_' . $locale} }}</h4>
                                <div class="shop">
                                    <a class="btn btn-normal" href="{{ $content->{'link_' . $locale} ?? '' }}">{{ __('words.shop_now') }}</a>
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
