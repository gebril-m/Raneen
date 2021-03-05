@extends('layouts.app')
@section('container')
<br><br><br><br><br><br><br><br><br>

<!-- thank-you section start -->
<section class="section-big-py-space light-layout">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="success-text"><i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2>thank you</h2>
                    <p>Payment is successfully processsed and your order is on the way</p>
                    <p>Order ID:{{$order->id}}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section ends -->


<!-- order-detail section start -->
<section class="section-big-py-space mt--5 bg-light">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-order">
                    <h3>your order details</h3>
                    
                        @php    
                            $prices = 0;
                            $discounts = 0;
                        @endphp
                        @foreach($order->products as $product)
                            @php
                                $prices += $product->pivot->total;
                                $discounts += $product->pivot->disount;
                            @endphp
                            <div class="row product-order-detail">
                            <div class="col-3"><img src="{{ $product->thumbnail }}" alt="" class="img-fluid "></div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>product name</h4>
                                        <h5>{{ $product->name }}</h5></div>
                                </div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>quantity</h4>
                                        <h5>{{$product->pivot->quantity}}</h5></div>
                                </div>
                                <div class="col-3 order_detail">
                                    <div>
                                        <h4>price</h4>
                                        <h5>{{$product->pivot->price}}</h5></div>
                                </div>
                            </div>
                        @endforeach

                    <div class="total-sec">
                        <ul>
                            <li>subtotal <span>{{$prices}}</span></li>
                            @if($discounts != 0)
                                <li>cupon discount <span>{{$discounts}}</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="final-total">
                        <h3>total <span>{{($prices) - $discounts}}</span></h3></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row order-success-sec">
                    <div class="col-sm-4">
                        <h4>summery</h4>
                        <ul class="order-detail">
                            <li>order ID: {{$order->id}}</li>
                            <li>Order Date: {{$order->created_at->format('M d, Y')}}</li>
                            <li>Order Total: {{$prices - $discounts}}</li>
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h4>shipping address</h4>
                        <ul class="order-detail">
                            <li>{{$order->address}}</li>
                        </ul>
                    </div>
                    @if(!empty($order->lat) && !empty($order->lng))
                        <div class="col-sm-4">
                            <h4>Map Location</h4>
                            <div id="map" style="height: 200px;border: 1px solid #000;"></div>
                        </div>
                        <div class="col-sm-12 payment-mode">
                            <h4>payment method</h4>
                            <p>Pay on Delivery (Cash/Card)</p>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <div class="delivery-sec">
                            <h3>expected date of delivery</h3>
                            <h2>{{$order->created_at->format('M d, Y')}}</h2></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section ends -->
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
};
</script>
@endif
@endsection