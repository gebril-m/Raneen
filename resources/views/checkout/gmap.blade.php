@extends('layouts.app')
@section('container')
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>cart</h2>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="#">cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<br><br>  
<br>



<!--section start-->
<section class="login-page section-big-py-space bg-light">
    <div class="custom-container">
        <div class="row">
        <div class="col-md-12">
<div id="map" style="height: 400px;border: 1px solid #000;overflow:scroll"></div>
</div>
        </div>
    </div>
</section>
<!--Section ends-->

@section('script')
@if(!empty($lat) && !empty($lng))
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
    window.onload = function() {
        var latlng = new google.maps.LatLng({{$lat}}, {{$lng}});
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