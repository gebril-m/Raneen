@extends('website.layouts.master')

@section('title',__('User.Wishlist'))

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')

  <section class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
      @include('website.users.sidebar')

        <div class="col-main col-sm-9 col-xs-12">
          <div class="my-account">
            <div class="page-title">
              <h2>{{__('User.My Wishlist')}}</h2>
            </div>
            <div class="wishlist-item table-responsive">
              <table class="col-md-12">
                <thead>
                  <tr>
                    <th class="th-delate">{{__('User.Remove')}}</th>
                    <th class="th-product">{{__('User.Image')}}</th>
                    <th class="th-details" >{{__('User.Product Name')}}</th>
                    <th class="th-price">{{__('User.Unit price')}}</th>
                    <th class="th-total th-add-to-cart">{{__('User.Add To Cart')}} </th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($cart) > 0)
                  @foreach($cart as $product)
                  <tr>
                    <td class="th-delate removeWishlist" productId="{{$product['id']}}"><a href="#" >X</a></td>
                    <td class="th-product"><a href="#"><img src="{{$product['thumbnail']}}" alt="cart"></a></td>
                    <td class="th-details"><h2 style="text-align: center"><a href="#">{{$product['name']}}</a></h2></td>
                    <td class="th-price">{{$product['price']}} @if($product['before_price'])<span class="old-price" style="text-decoration: line-through">{{$product['before_price']}}</span>@endif</td>
                    
                     
                  @if($product['stock'] > 0)
                    <th class="td-add-to-cart website_addtocart"style="padding: 4px 8px" productid="{{$product['id']}}"><a href="#"> {{__('User.Add To Cart')}}</a></th>
                  @else
                  <td>
                         {{__('Product.Out Of Stock')}}
                  </td>
                    
                  @endif
                
                    
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
              <!-- <a href="checkout.html" class="all-cart">Add all to cart</a> </div> -->
          </div>
        </div>
      </div>
      </div>
    </div>
  </section>


@include('website.components.footer')





@endsection

@section('javascript')

@endsection