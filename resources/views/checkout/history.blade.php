@extends('layouts.app')
@section('container')
<!-- breadcrumb start -->
<div class="breadcrumb-main mtpage">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>{{trans('cart.cart')}}</h2>
                        <ul>
                            <li><a href="#">{{trans('home.home')}}</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="#">{{trans('cart.cart')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<!-- section start -->
<!--section start-->
<!-- `first_name`, `last_name`, `phone`, `email`, `country_id`, `address`, `lat`, `lng`, `city_id`, `state`, `postal_code`, `status_id` -->
<section class="cart-section order-history section-big-py-space">
    <div class="custom-container">
        <div class="row">
            <div class="col-sm-12">

                @if($orders->count() != 0)
                    <div class="accordion" id="accordionExample">

                        @foreach($orders as $k => $order)
                        @php
                            $orderProducts = $order->products;
                            $orderRewardPoints = $orderProducts->sum('pivot.reward_points');
                            $orderRewardPoint = $orderProducts->sum('reward_points');
                        @endphp
                            <div class="card" >
                                <div class="card-header" id="headingOne" style="background-color:#fff">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne{{$k}}" aria-expanded="true" aria-controls="collapseOne">
                                        {{trans('home.order no')}}: {{$order->id}}
                                    </button>
                                    @if($orderRewardPoints > 0)
                                        <span class="badge badge-info">
                                        <h4>
                                            ( {{$orderRewardPoints}} trans('home.reward points')}})
                                        </h4>
                                        </span>
                                    @endif
                                </h5>
                                <br>
                                <!-- order information -->
                                <table class="table cart-table table-responsive-xs" style="">
                                    <thead>
                                    <tr class="table-head">
                                        <th scope="col">{{trans('order.first name')}}</th>
                                        <th scope="col">{{trans('order.last name')}}</th>
                                        <th scope="col">{{trans('order.phone')}}</th>
                                        <th scope="col">{{trans('order.email')}}</th>
                                        <th scope="col">{{trans('order.address')}}</th>
                                        @if(!empty($order->lat) && !empty($order->lng))
                                            <th scope="col">{{trans('order.map location')}}</th>
                                        @endif
                                        <th scope="col">{{trans('order.postal code')}}</th>
                                    </tr>
                                    </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$order->first_name}}</td>
                                                <td>{{$order->last_name}}</td>
                                                <td>{{$order->phone}}</td>
                                                <td>{{$order->email}}</td>
                                                <td>{{$order->address}}</td>
                                                <td>
                                                <a href="{{route('web.gmap.show')}}?lat={{$order->lat}}&lng={{$order->lng}}" target="_blank">Show Map</a>
                                                </td>
                                                <td>{{$order->postal_code}}</td>
                                            </tr>
                                        </tbody>
                                </table>
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne{{$k}}" aria-expanded="true" aria-controls="collapseOne">
                                        {{trans('home.order no')}}: {{$order->id}} information
                                    </button>
                                </h5>
                                </div>
                                <div id="collapseOne{{$k}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                <table class="table cart-table table-responsive-xs">
                                    <thead>
                                    <tr class="table-head">
                                        <th scope="col">{{trans('product.product')}}</th>
                                        <th scope="col">{{trans('product.description')}}</th>
                                        <th scope="col">{{trans('product.discounted price')}}</th>
                                        <th scope="col">{{trans('product.total price')}}</th>
                                        <th scope="col">{{trans('product.unit price')}}</th>
                                        <th scope="col">{{trans('product.detail')}}</th>
                                        <th scope="col">{{trans('product.status')}}</th>
                                    </tr>
                                    </thead>
                                        @php
                                            $totalCounter = 0;
                                        @endphp
                                        @foreach($orderProducts as $product)
                                            @php
                                                $totalCounter += $product->pivot->price * $product->pivot->quantity;
                                            @endphp
                                            <tbody>
                                            <tr>
                                                <td>

                                                    <a href="#"><img src="{{$product->thumbnail}}" alt="product" class="img-fluid  "></a>
                                                </td>
                                                <td><a href="#">{{trans('home.order no')}}: <span class="dark-data">{{$order->id}}</span>


                                                <br>{{ $product->name }}

                                                </a>
                                                    <div class="mobile-cart-content row">
                                                        <div class="col-xs-3">
                                                            <div class="qty-box">
                                                                <div class="input-group">
                                                                    <input type="text" name="quantity" class="form-control input-number" value="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <h4 class="td-color">$63.00</h4></div>
                                                        <div class="col-xs-3">
                                                            <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h4 class="text-center">{{ ($product->pivot->price_after == $product->pivot->price) ? $product->pivot->price_after : '-' }}</h4>
                                                </td>
                                                <td>
                                                    <h4 class="text-center">{{$product->pivot->price * $product->pivot->quantity}}</h4>
                                                </td>
                                                <td>
                                                    <h4 class="text-center">{{$product->pivot->price}}</h4>
                                                </td>

                                                <td>
                                                    <!-- <span>Size: L</span><br> -->
                                                    <span>Quntity: {{$product->pivot->quantity}}</span>
                                                </td>
                                                <td>
                                                    <div class="responsive-data">
                                                        <h4 class="price">{{$product->pivot->price}}</h4>
                                                        <span>Size: L</span>|<span>Quntity: {{$product->pivot->quantity}}</span>
                                                    </div>
                                                    <span class="dark-data">Delivered</span>
                                                </td>
                                            </tr>
                                            </tbody>

                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align:center;padding-right:0;padding-left:0;">
                                                    <b>
                                                        {{ $totalCounter }}
                                                    </b>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>

                                </table>

                                    </div>

                                </div>


                            </div>
                        @endforeach

                    </div>
                @else
                    <section class="bg-white section-big-py-space">
                        <div class="title3 ">
                            <h4>
                               {{trans('history.History is empty')}}
                            </h4>
                            <br>
                            <a href="{{ URL::previous() }}" class="btn btn-danger btn-lg">{{trans('home.back')}}</a>
                        </div>
                    </section>
                @endif
            </div>
        </div>
        <!-- <div class="row cart-buttons">
            <div class="col-12 pull-right"><a href="#" class="btn btn-normal btn-sm">show all orders</a></div>
        </div> -->
    </div>
</section>
<!--section end-->
@endsection
@section('script')
@if(!empty($order->lat) && !empty($order->lng))
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
window.onload = function() {
    var latlng = new google.maps.LatLng({{$order->lat}}, {{$order->lng}});
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: 'Set lat/lon values for this property',
        draggable: true
    });

    var zoomer = document.getElementById('zoomer');
};

</script>
@endif
@endsection
