<ul class="products-grid">
	@if(count($products) > 0)
	@foreach($products as $product)
  <li class="item col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
    @include('website.components.products-card', [
                    'product' => $product
                ])
  </li>
  @endforeach
  @else
	<p class="text-center">{{__('Product.No Products Found')}}</p>
  @endif
</ul>
<div style="display: none">
@if(!isset($_GET['show']))
{!!$products->appends(request()->input())->render()!!}
@endif
</div>

<script>
	$('.products-grid').infiniteScroll({
      // options
      path: '.page-link[rel="next"]',
      append: '.products-grid',
      history: false,
    });
</script>