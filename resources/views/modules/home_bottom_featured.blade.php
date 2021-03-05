@if($content)

    <!-- media banner tab start-->
    <section class=" ratio_square">
        <div class="custom-container b-g-white section-pb-space">
            <div class="row">
                <div class="col p-0">
                    <div class="theme-tab product">
                        <ul class="tabs tab-title media-tab">
                            @if(isset($content->new_active) && $content->new_active)<li class="current"><a href="tab-new_products">{{ __('words.new_product') }}</a></li>@endif
                            @if(isset($content->feature_active) && $content->feature_active)<li class=""><a href="tab-feature_products">{{ __('words.feature_products') }}</a></li>@endif
                            @if(isset($content->best_active) && $content->best_active)<li class=""><a href="tab-best_sellers">{{ __('words.best_sellers') }}</a></li>@endif
                            @if(isset($content->sale_active) && $content->sale_active)<li class=""><a href="tab-on_sale">{{ __('words.on_sale') }}</a></li>@endif
                        </ul>
                        <div class="tab-content-cls">
                            @if(isset($content->new_active) && $content->new_active)
                                <div id="tab-new_products" class="tab-content active default ">

                                    @php
                                    $new_products = \App\Product::limit($content->new_limit)
                                        ->where('is_active', true)
                                        ->where('stock', '>', 0)
                                        ->orderBy('created_at', 'DESC')->get();
                                    @endphp

                                    @include('modules.blocks.feature_tab', [
                                        'products' => $new_products
                                    ])
                                </div>
                            @endif
                            @if(isset($content->feature_active) && $content->feature_active)
                                <div id="tab-feature_products" class="tab-content">

                                    @php
                                    $new_products = \App\Product::limit($content->feature_active)
                                        ->where('is_active', true)
                                        ->where('stock', '>', 0)
                                        ->orderBy('created_at', 'DESC')->get();
                                    @endphp

                                    @include('modules.blocks.feature_tab', [
                                        'products' => $new_products
                                    ])
                                </div>
                            @endif
                            @if(isset($content->best_active) && $content->best_active)
                                <div id="tab-best_sellers" class="tab-content">

                                    @php
                                    $new_products = \App\Product::limit($content->best_limit)
                                        ->where('is_active', true)
                                        ->where('stock', '>', 0)
                                        ->orderBy('created_at', 'DESC')->get();
                                    @endphp

                                    @include('modules.blocks.feature_tab', [
                                        'products' => $new_products
                                    ])
                                </div>
                            @endif
                            @if(isset($content->sale_active) && $content->sale_active)
                                <div id="tab-on_sale" class="tab-content">

                                    @php
                                    $new_products = \App\Product::limit($content->sale_limit)
                                        ->where('is_active', true)
                                        ->where('stock', '>', 0)
                                        ->orderBy('created_at', 'DESC')->get();
                                    @endphp

                                    @include('modules.blocks.feature_tab', [
                                        'products' => $new_products
                                    ])
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- media banner tab end -->
@endif
