@if($product)
@if(isset($product->get_product($product->product_id)->url))
<li class="item col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
	@include('website.components.products-card-category');
</li>
@endif
@endif
