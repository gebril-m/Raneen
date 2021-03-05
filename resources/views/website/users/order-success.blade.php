@extends('website.layouts.master')

@section('title',__('User.Order Success'))

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

        <div class="page-content page-order">
          <div class="row" style="background-color: #f8f8f8;padding:0 20px;">
          <div class="success-icon">&#10004;</div>
          <h2 class="col-xs-12 " style="font-weight: 600;text-align: center;"> {{__('User.Order Complete')}}</h2>
          <div class="col-xs-12  row" style="padding: 30px;">
            <div class="col-md-4 col-xs-6">
              <h3>{{__('Users.Summery')}}</h3>
              @php
                      $prices = 0;
                      $discounts = 0;
                  @endphp
                  @foreach($order->products as $product)



                          @if (isset($product->pivot->price_after))

                              @php
                            $prices += $product->pivot->price_after
                            @endphp
                          @else
                              @php
                            $prices += $product->pivot->total;
                            @endphp
                          @endif
                          @php
                          $discounts += $product->pivot->disount;
                          @endphp

                  @endforeach
              <ul style="margin: 0 0 10px 12px;">
                <li style="font-size: 14px;font-weight: 600;color: grey;">{{__('User.Order Number')}}:<span style="color: #b22827;padding: 0 5px;">{{$order->id}}</span> </li>
                <li  style="font-size: 14px;font-weight: 600; color: grey;">{{__('User.Order Date')}}: <span style="color: #b22827;padding: 0 5px;"> {{$order->created_at->format('M d, Y')}}</span></li>
                <li style="font-size: 14px;font-weight: 600; color: grey;">{{__('User.Order Total')}}:  <span style="color: #b22827;padding: 0 5px;">{{$prices}}</span></li>

                @if($discounts != 0)
                <li style="font-size: 14px;font-weight: 600; color: grey;">{{__('Users.Discounts')}}:  <span style="color: #b22827;padding: 0 5px;">{{$discounts}}</span></li>
                <li style="font-size: 14px;font-weight: 600; color: grey;">{{__('Users.After Discount')}}:  <span style="color: #b22827;padding: 0 5px;">{{$prices-$discounts}}</span></li>
                @endif
              </ul>
            </div>
            <div class="col-md-4 col-xs-6">
              <h3>{{__('Users.Shipping information')}}</h3>
              <ul style="margin: 0 0 10px 12px;">
                <li style="font-size: 14px;font-weight: 600;color: grey;">{{$order->address}}</li>
                <li style="font-size: 14px;font-weight: 600;color: grey;">{{__('User.Phone')}}: <span style="color: #b22827;padding: 0 5px;">{{$order->phone}}</span></li>
              </ul>
            </div>
            <div class="col-md-4 col-xs-6">
              <h3>{{__('Users.payment method')}}</h3>
              <ul  style="margin: 0 0 10px 12px;">
                <li style="font-size: 14px;font-weight: 600;color: grey;">{{$order->payment_method()}}</li>

              </ul>
            </div>
          </div>
          <div class="col-xs-12" style="text-align: center; padding: 20px;">
            <h2 style="font-weight: 600;">{{__('Users.Expected Date Of Delivery')}}</h2>
            <h2 style="font-weight: 600;color: #b22827;">{{date("d/m/y", strtotime(date('d-m-Y', strtotime(' + 5 days', strtotime($order->created_at)))))}}</h2>
          </div>
        </div>
          <div class="order-detail-content" style="margin: 0;">
            <div class="table-responsive">
              <table class="table table-bordered cart_summary">
                <thead>
                  <tr>
                    <th class="cart_product" style="background-color: #b22827;color: #ffffff;">{{__('Users.Product')}}</th>
                    <th  style="background-color: #b22827;color: #ffffff;">{{__('Users.Description')}}</th>

                    <th style="text-align: start;background-color: #b22827;color: #ffffff;">{{__('Users.Qty')}}</th>
                    <th style="text-align: start;background-color: #b22827;color: #ffffff;">{{__('Users.Total')}}</th>
                  </tr>
                </thead>
                <tbody>
                @php
                      $prices = 0;
                      $discounts = 0;
                      $after_disc = 0;
                      $discount_found = 0;
                  @endphp
                  @foreach($order->products as $product)

                  <tr>
                    <td class="cart_product"><a href="#"><img src="{{ image('product',$product->get_images($product->id)[0]) }}" alt="Product"></a></td>
                    <td class="cart_description"><p class="product-name"><a href="#">{{ $product->name }}</a></p>
                      <!-- <small><a href="#">Color : Red</a></small>
                      <small><a href="#">Size : M</a></small> -->
                    </td>
                    <td class="qty" style="width: auto;"><input  type="text" value="{{$product->pivot->quantity}}" disabled></td>
                    <td class="price" >
                      <span>

                      @if($product->pivot->total != $product->pivot->price_after)

                        <s style="text-decoration: line-through;">${{$product->pivot->total}}</s> ${{$product->pivot->price_after}}
                        @php
                            $discount_found = 1;
                            $prices += $product->pivot->price_after;
                            $discounts += $product->pivot->price_after;
                            $after_disc += $product->pivot->price_after;
                        @endphp
                      @else
                      ${{$product->pivot->total}}
                      @php
                          $prices += $product->pivot->price_after;
                          $after_disc += $product->pivot->price_after;
                      @endphp
                      @endif
                      </span>
                    </td>
                  </tr>
                  @endforeach


                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3" style="text-align: start">{{__('Users.Total products')}}</td>
                    <td colspan="2" style="text-align: center">${{$prices}} </td>
                  </tr>
                  <tr>
                    <tr>
                      <td colspan="3" style="text-align: start">{{__('Users.Shipping')}}</td>
                      <td colspan="2" style="text-align: center">${{$order->shipping_amount}} </td>
                    </tr>
                    <tr>
                      <td colspan="3" style="text-align: start"><strong>{{__('Users.Total')}}</strong></td>
                      <td colspan="2" style="text-align: center"><strong>${{$prices+$order->shipping_amount}} </strong></td>
                    </tr>
                    @if($discount_found == 1)
                    <tr>
                      <td colspan="3" style="text-align: start"><strong>{{__('Users.Total After Discount')}}</strong></td>
                      <td colspan="2" style="text-align: center"><strong>${{$after_disc+$order->shipping_amount}} </strong></td>
                    </tr>
                    @endif
                </tfoot>
              </table>
            </div>
            <div class="cart_navigation">
                <a class="continue-btn" href="{{url('/'.$locale.'/order/history')}}"><i class="fa fa-arrow-left"> </i>&nbsp; {{__('users.Go To Order Tracking')}}</a>
                <a class="checkout-btn" href="{{url('/'.$locale.'/')}}"><i class="fa fa-check"></i>{{__('Users.Continue shopping')}}</a>
            </div>

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
