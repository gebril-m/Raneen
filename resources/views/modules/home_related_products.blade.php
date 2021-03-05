@if($content)

    <!--title start-->
    <div class="title1 section-my-space">
        <h4>{{trans('home.related_products')}}</h4>
    </div>
    <!--title end-->

    <!--product start-->
    <section class="product section-pb-space mb--5">
        <div class="custom-container">
            <div class="row">
                <div class="col pr-0">
                    <div class="product-slide-6 no-arrow">

                        @php
                            // $product = \App\Product::find($pId);
                            $_visited_products = session('visited_products', []);
                            $visited_products = [];
                            if (sizeof($_visited_products) > 0) {
                                $visited_products = \App\Product::whereIn('id', $_visited_products)
                                    ->where('is_active', true)
                                    ->where('stock', '>', 0)
                                    ->get();
                            }
                        @endphp
                        @foreach($visited_products as $product)


                            @include('modules.blocks.product_card', [
                                'product' => $product
                            ])

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--product end-->
@endif
