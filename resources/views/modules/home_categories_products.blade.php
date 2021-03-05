@if($content)
        @php
        $dbCats = [];
        foreach ($content->categories as $item) {
            $dbCat = \App\Category::find($item->category);
            if(!$dbCat) continue;
            $dbCats[$item->category] = $dbCat;
        }
        @endphp

    <!--tab product-->
    <section class="" >
        <div class="tab-product-main">
            <div class="tab-prodcut-contain">
                <ul class="tabs tab-title">
                    @foreach($content->categories as $item)
                        @php
                        if(!isset($dbCats[$item->category])) continue;
                        $dbCat = $dbCats[$item->category];
                        @endphp
                    <li @if($loop->index == 0) class="current" @endif ><a href="tab-{{ $item->category }}">{{ $dbCat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <!--tab product-->

    <!-- slider tab  -->
    <section class="section-py-space ratio_square product">
        <div class="custom-container">
            <div class="row">
                <div class="col pr-0">
                    <div class="theme-tab product mb--5">
                        <div class="tab-content-cls ">
                            @foreach($content->categories as $item)
                                @php
                                    if(!isset($dbCats[$item->category])) continue;
                                    $dbCat = $dbCats[$item->category];
                                @endphp
                                <div id="tab-{{ $item->category }}" class="tab-content @if($loop->index == 0) active @endif">
                                    <div class="product-slide-6 product-m no-arrow">

                                        @php
                                            $products = $dbCat->products()->with(['promotions' => function($q){
                                                $q->orderBy('end', 'desc')->get()->first();
                                            }])
                                            ->where('is_active', true)
                                            ->where('stock', '>', 0)
                                            ->limit(10)->get();
                                        @endphp

                                        @foreach($products as $product)
                                            @include('modules.blocks.product_card', [
                                               'product' => $product
                                           ])
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider tab end -->
@endif
