@if($content)

    <!--title start-->
    <div class="title1 section-my-space">
        <h4>{{trans('home.Special Products')}}</h4>
    </div>
    <!--title end-->

    <!--product start-->
    <section class="product section-pb-space mb--5">
        <div class="custom-container">
            <div class="row">
                <div class="col pr-0">
                    <div class="product-slide-6 no-arrow">

                        @foreach($content->products as $pId)
                            @php
                                $product = \App\Product::find($pId);
                            @endphp

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
