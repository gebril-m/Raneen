@extends('website.layouts.master')

@section('title',__('User.Cart'))

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')

  <section class="main-container col1-layout">
    <div class="main container">
      <div class="col-main">
        <div class="cart">
          
          <div class="page-content page-order"><div class="page-title">
            <h2>{{__('User.Shopping Cart')}}</h2>
          </div>
            
            
          @if(session()->has('message'))
                <div class="alert alert-warning">
                    {{__('User.No Products Found')}}
                </div>
            @endif
            <div class="order-detail-content">
              <div class="table-responsive">
                <table class="table table-bordered cart_summary">
                  <thead>
                    <tr>
                      <th class="cart_product">{{__('User.Product')}}</th>
                      <th>{{__('User.Description')}}</th>
                      <th>{{__('User.Attributes')}}</th>
                      <th>{{__('User.Avail')}}</th>
                      <th>{{__('User.Unit price')}}</th>
                      <th>{{__('User.Qty')}}</th>
                      <th>{{__('User.Total')}}</th>
                      <th class="action"><i class="fa fa-trash-o"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($cart) > 0)
                  @foreach($cart as $product)
                    <?php $pro=\App\Product::find($product['id']); 
                    
                    ?> 
                    <tr class="cart-line-{{$product['id']}}">
                      <td class="cart_product"><a href="{{$product['url']}}"><img src="{{$product['thumbnail']}}" alt="Product"></a></td>
                      <td class="cart_description"><p class="product-name"><a href="{{$product['url']}}">{{$product['name']}}</a></p></td>
                      <td style="text-align: start">
                        @if(count($product['attrs_details']))
                          @foreach($product['attrs_details'] as $attr)
                            <span class="label label-default" style="display: inline-block;margin:5px">{{$attr->name}}</span>
                          @endforeach
                        @else
                        {{__('Cart.No Attributes')}}
                        @endif
                      </td>


                      @if($pro->stock > 0)

                        @if($pro->is_bundle == 1 )
                          @php
                            $BundleItemsStock=$pro->checkBundleItemsStock($product['id']);  
                          @endphp
                          @if( $BundleItemsStock['status'] =="fail") 
                            <td class="availability in-stock"><span class="label">{{__('User.Out Of Stock')}}</span></td>
                          @else
                             <input type="hidden" id="product_qty{{$product['id']}}" value="{{ $BundleItemsStock['productBundleStock'] }}" > 
                             <td class="availability in-stock"><span class="label">{{ $BundleItemsStock['productBundleStock'] }} {{__('User.In Stock')}}</span></td>
                          @endif
                        @else
                          <input type="hidden" id="product_qty{{$product['id']}}" value="{{ $pro->stock }}" > 
                          <td class="availability in-stock"><span class="label">{{ $pro->stock }} {{__('User.In Stock')}}</span></td>
                        @endif

                      @else
                        <td class="availability out-of-stock"><span class="label">{{__('User.Out Of Stock')}}</span></td>
                      @endif

                      
                      <td class="price"><span>{{$pro->getFinalPriceAfterDiscountPriroty()}}
                      @if($pro->is_offer() )
                        
                        <span class="old-price" style="text-decoration: line-through">{{$pro->getFinalOldPricePriroty()}}</span>
                        
                        

                      @endif</span></td>  
                      <td class="qty" style="width: 200px">
                        <div class="numbers-row quantity_cart" style="float: none">
                         
                        <div onclick="var product_qty=document.getElementById('product_qty{{$product['id']}}').value;  var result = document.getElementById('qty{{$product['id']}}'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; (qty >= 1 && qty <= parseInt(product_qty) - 1)) result.value++;return false;" class="inc qtybutton qtybutton2" style="padding:8px 12px 5px 12px; line-height:0 ; height:auto ;float:none"><i class="fa fa-plus"></i></div>
                          <input type="number" class="qty qty-update" title="Qty" maxlength="12" id="qty{{$product['id']}}" name="qty" value="{{$product['quantity']}}" productId="{{$product['id']}}" style="  height: 28px; ">
                          <div onclick="var result = document.getElementById('qty{{$product['id']}}'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;" class="dec qtybutton qtybutton2" style="padding:8px 12px 5px 12px; line-height:0 ; height:auto ;float:none"><i class="fa fa-minus pa-ar"></i></div>

                        </div>
                      </td>
                      <td class="price price_total"><span>{{(float) str_replace(',', '', $product['price']) * $product['quantity'] }}</span></td>
                      <td class="action"><a href="#" class="removeProduct" productId="{{$product['id']}}"><i class="icon-close"></i></a></td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                  @if($total)
                  <tfoot>
                    <tr>
                      <td colspan="2" rowspan="2"></td>
                      <td colspan="3">{{__('User.Total products (tax included)')}}</td>
                      <td colspan="3" class="total_price_cart">{{$total}} </td>
                    </tr>
                    <tr>
                      <td colspan="3"><strong>{{__('User.Total')}}</strong></td>
                      <td colspan="3"><strong class="total_price_cart">{{$total}} </strong></td>
                    </tr>
                  </tfoot>
                  @endif
                </table>
              </div>
              <div class="cart_navigation"> <a class="continue-btn" href="{{url('/'.$locale)}}"><i class="fa fa-arrow-left sc"> </i>&nbsp; {{__('User.Continue shopping')}}</a> <a class="checkout-btn" href="{{url('/'.$locale.'/checkout')}}"><i class="fa fa-check"></i> {{__('User.Proceed to checkout')}}</a> </div>
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