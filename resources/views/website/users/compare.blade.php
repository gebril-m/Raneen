@extends('website.layouts.master')

@section('title',__('User.Compare'))

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')
<section class="blog_post">
    <div class="container"> 
      
      <!-- Center colunm-->
      <div class="blog-wrapper">
        <div class="page-title">
          <h2>{{__('Product.Compare Products')}}</h2>
        </div>
        <ul class="blog-posts">
    	@if(isset($compares) && count($compares) > 0)
	        @foreach($compares as $product)
	          <li class="post-item col-md-4">
	           <div class="blog-box"> <a href="{{$product->url}}"> <img class="primary-img" src="{{$product->thumbnail_url}}" alt="{{$product->name}}"></a>
	                <div class="blog-btm-desc">
	                  <div class="blog-top-desc">
	                    <h4><a href="{{$product->url}}">{{$product->name}}</a></h4>
	                 <h5>{{$product->price}}</h5>
	                  <p>{!!$product->description!!}</p>
	                  <div>
						
					  @if($product->is_bundle == 0 && $product->is_combo == 0)
                  @if($product->stock > 0)
                    @if($product->stock <= $product->minimum_stock)
                    <button class="add-cart button button-sm website_addtocart" style="padding: 4px 8px" productId="{{$product->id}}"><i class="fa fa-shopping-basket"></i></button>
                    @else
					<button class="add-cart button button-sm website_addtocart" style="padding: 4px 8px" productId="{{$product->id}}"><i class="fa fa-shopping-basket"></i></button>
                    @endif
                  @else
                   
                        <i></i> {{__('Product.Out Of Stock')}}
                     
                    
                  @endif
                @endif
					 	
					  

						<button class="button button-sm add_to_wishlist"><i class="ti-heart" productId="{{$product->id}}"></i></button>
	                  <button class="button button-sm remove-compare" data-productid="{{$product->id}}"><i class="fa fa-close"></i></button>
	                  </div>
	              </div>
	          </li>
	          @endforeach
          @endif
      
        </ul>
       
      </div>
      <!-- ./ Center colunm --> 
      
    </div>
  </section>

@include('website.components.footer')





@endsection

@section('javascript')

@endsection