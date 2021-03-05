@if(isset($products))
<div class="slide-5 product-m no-arrow">
    @foreach($products->chunk(3) as $cproducts)
    @include('modules.blocks.feature', [
        'products' => $cproducts,
    ])
    @endforeach
</div>
@endif
