@extends('layouts.app')
@section('container')
<div class="breadcrumb-main margin-large">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>{{trans('home.checkout')}}</h2>
                        <ul>
                            <li><a href="#">{{trans('home.home')}}</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="#">{{trans('home.checkout')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="section-big-py-space bg-light">
    <div class="custom-container">
        <div class="checkout-page contact-page">
            @if(count($errors->all()) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{$err}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="checkout-form">
                @php
                $admin = 0 ;
                if(auth()->check()){
                    if(auth()->user()->is_admin){
                      $admin = 1 ;
                    }
                }
                @endphp
@if(!$admin)
                @if(!empty($nproducts['cartProducts']))
                        <form method="post" action="{{route('web.checkout.send')}}" id="dataToSaveOrderBefore">
                            @csrf
                            <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-details theme-form  section-big-mt-space">

                                        <div class="order-box">
                                            <div class="title-box">
                                                <div>{{trans('home.Product')}} <span>{{trans('home.Total')}}</span></div>
                                            </div>

                                            <ul class="qty">

                                                @foreach( $nproducts['cartProducts'] as $product)

                                                    <li>
                                                        {{$product['name']}} × {{$product['quantity']}}
                                                    </li>
                                                    <li>total <span class="count">
                                                        ({{ $product['price'] / $product['quantity']  . '*' . $product['quantity']}}) =
                                                        {{ $product['price']}}
                                                    </span></li>

                                                @endforeach

                                            </ul>

                                            <!--<ul class="sub-total">
                                            <li>Subtotal <span class="count">{{ $nproducts['totalPrice'] }}</span></li>
                                                <li>Shipping
                                                    <div class="shipping">
                                                        <div class="shopping-option">
                                                            <input type="checkbox" name="free-shipping" id="free-shipping">
                                                            <label for="free-shipping">Free Shipping</label>
                                                        </div>
                                                        <div class="shopping-option">
                                                            <input type="checkbox" name="local-pickup" id="local-pickup">
                                                            <label for="local-pickup">Local Pickup</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>-->
                                            <ul class="total">

                                                <li>{{trans('home.Sub Total')}} <span class="count">{{ $nproducts['totalPrice'] }}</span></li>
                                                @if($nproducts['totalDiscounts'] != 0)
                                                    <li>{{trans('home.Discount')}} <span class="count">{{ $nproducts['totalDiscounts'] }}- </span></li>
                                                    <li>{{trans('home.Total Price')}} <span class="count">{{ $nproducts['totalPriceAfter'] }}</span></li>
                                                @endif
                                            </ul>
                                        </div>
                                    @if(Auth::check())


                                            <div class="payment-box">
                                                <div class="upper-box">
                                                </div>
                                                <div class="text-right">
                                                    @if(session()->has('message'))
                                                        <span class="badge badge-info">
                                                            {{ session()->get('message') }}
                                                        </span>
                                                    @endif
                                                    <div class="input-group">
                                                        <input type="text" name="cupon_code" placeholder="insert cupon code" id="cupon_code" value="{{ old('cupon_code') }}">
                                                        <button class=" btn btn-normal" id="cupon_submitter" style="cursor:pointer;font-size: 12px;padding: 10px 10px;">
                                                           {{trans('home.Click To Apply Coupon')}}
                                                        </button>
                                                    </div>
                                                <hr>
{{--                                                <div class="text-right">--}}
{{--                                                    <button class="btn-normal btn" type="submit">{{trans('home.Place Order')}}</button>--}}
{{--                                                </div>--}}

                                            </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">استلام الشحنة</label>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ship_to_home" id="send_to_home" value="home" checked>
                                                            <label class="form-check-label mx-3" for="send_to_home">التوصيل الي المنزل</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ship_to_inventory" id="receive_from_location" value="location">
                                                            <label class="form-check-label mx-3" for="receive_from_location">استلام من الفرع</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12" style="display: none" id="location-container">
                                                        <select name="location_id" id="location_id">
                                                            @foreach(\App\Location::all() as $location)
                                                                <option value="{{ $location->id }}">{{ $location->location }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>

                                            </div>
                                        <!--section start-->
                                        <!-- <section class="contact-page section-big-py-space bg-light"> -->
                                        <div class="custom-container">
                                            <!--<div class="row section-big-pb-space">
                                                <div class="col-xl-6 offset-xl-3"> -->
                                            <h3 class="text-center m-3">طريقة الدفع</h3>
                                            <div class="">

                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">pay by card</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">pay on delvired</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <!-- <form class="payment-form text-left"  id="payfort_fort_form" action="{{url('/payfortToken')}}" method="post"> -->

                                                        <div class="form-group">
                                                            <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_card_holder_name" >Name on Card</label>
                                                            <div class="large-12 medium-12 small-12 column">
                                                                <input type="text" class="form-control in-style" id="payfort_fort_card_holder_name" name="card_holder_name" value="" placeholder="Name on card" maxlength="50" minlength="3">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_card_number">Card Number</label>
                                                            <div class="large-12 medium-12 small-12 column">
                                                                <input type="text" class="form-control in-style" id="payfort_fort_card_number" name="card_number" value="" placeholder="Credit card number" maxlength="16" minlength="14">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="large-6 medium-6 small-6 column">
                                                                <div class="form-group m-2">
                                                                    <label >expiry month *</label>
                                                                    <select class="form-control" size="1" name="expiry_month" id="payfort_fort_expiry_month">
                                                                        <option value="01">Jan - 01</option>
                                                                        <option value="02">Feb - 02</option>
                                                                        <option value="03">Mar - 03</option>
                                                                        <option value="04">Apr - 04</option>
                                                                        <option value="05">May - 05</option>
                                                                        <option value="06">June - 06</option>
                                                                        <option value="07">July - 07</option>
                                                                        <option value="08">Aug  - 08</option>
                                                                        <option value="09">Sep - 09</option>
                                                                        <option value="10">Oct - 10</option>
                                                                        <option value="11">Nov - 11</option>
                                                                        <option value="12">Dec - 12</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="large-6 medium-6 small-6 column">
                                                                <div class="form-group m-2">
                                                                    <label >expiry year *</label>
                                                                    <select class="form-control" size="1" name="expiry_year" id="payfort_fort_expiry_year">
                                                                        <?php
                                                                        $today = getdate();
                                                                        $year_expire = array();
                                                                        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
                                                                            $year_expire[] = array(
                                                                                'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                                                                                'value' => strftime('%y', mktime(0, 0, 0, 1, 1, $i))
                                                                            );
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        foreach($year_expire  as $year) {
                                                                            echo "<option value={$year['value']}>{$year['text']}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_cvv">Card CVV</label>
                                                            <div class="large-7 medium-7 small-7 column">
                                                                <input  type="text" class="form-control in-style" id="payfort_fort_cvv" name="cvv" value="" placeholder="CVV" maxlength="4">
                                                            </div>
                                                            <hr>
                                                            <div class="large-5 medium-5 small-5 column text-center">
                                                                <input type="submit" id="payfort_fort_pay_action" class="btn btn-normal" value="Pay">
                                                            </div>

                                                        </div>
                                                        <!-- </form> -->

                                                    </div>
                                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                        <!-- <form > -->
                                                        <div class="d-flex justify-content-center">
                                                            <div class="m-5">
                                                                <div class="form-check">
                                                                    <input required type="checkbox" name="cashOnelivery" id="cashOnelivery">
                                                                    <label for="cashOnelivery">Cash On Delivery</label>
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <input type="submit" id="payInDelvired" class="btn btn-normal" value="ordar now">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- </form> -->
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- </div>
                                        </div> -->
                                        </div>
                                        <!-- </section> -->
                                        <!--Section ends-->
                                        @endif




                                </div>



                            {{--
                            --}}

                                </div>

                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <div class="checkout-title">
                                        <h3>{{trans('home.Billing Details')}}</h3>
                                    </div>
                                    <div class="theme-form">
                                    @if(Auth::check())
                                        <div class="row check-out ">

                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>{{trans('home.First Name')}}</label>
                                                <input type="text"  name="first_name" value="{{ isset($user->first_name) ? $user->first_name : ''}}">
                                                @error('first_name')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>{{trans('home.Last Name')}}</label>
                                                <input type="text" name="last_name" value="{{ isset($user->last_name) ? $user->last_name : ''}}">
                                                @error('last_name')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label class="field-label">{{trans('home.Phone')}}</label>
                                                <input type="number" name="phone" value="{{ isset($user->phone) ? $user->phone : ''}}">
                                                @error('phone')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label class="field-label">{{trans('home.Email Address')}}</label>
                                                <input type="text" name="email" value="{{ isset($user->email) ? $user->email : ''}}">
                                                @error('email')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label class="field-label float-none">{{trans('home.Map location')}}</label> <br>
                                                <div id="map" style="height: 300px;border: 1px solid #000;"></div>
                                                <input type="hidden" id="lat_input" name="lat">
                                                <input type="hidden" id="lng_input" name="lng">
                                            </div>

                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label class="field-label">{{trans('home.Country')}}</label>
                                                {{ Form::select('country_id', $countries, isset($user->country_id) ? $user->country_id : '')}}
                                                <!-- {{ Form::select('country_id', $countries)}} -->
                                                @error('country_id')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label class="field-label">{{trans('home.Town/City')}}</label>
                                                {{ Form::select('city_id', $cities, isset($user->city_id) ? $user->city_id : '')}}
                                                <!-- {{ Form::select('city_id', $cities)}} -->
                                                @error('city_id')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label class="field-label">{{trans('home.Address')}}</label>
                                                <input type="text" name="address" value="{{ isset($user->address) ? $user->address : ''}}">
                                                @error('address')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                                <label class="field-label">{{trans('home.State / County')}}</label>
                                                <input type="text" name="state" value="{{ isset($user->state) ? $user->state : ''}}">
                                                @error('state')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                                <label class="field-label">{{trans('home.Postal Code')}}</label>
                                                <input type="number" name="postal_code" value="{{ isset($user->postal_code) ? $user->postal_code : ''}}">
                                                @error('postal_code')
                                                    <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <!-- <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <input type="checkbox" name="shipping-option" id="account-option"> &ensp;
                                                <label for="account-option">Create An Account?</label>
                                            </div> -->

                                        </div>
                                    @else
                                        <div class="text-right">
                                            <h4>
                                               {{trans('home.To Continue Checkout Process Please Do The Following')}}
                                            </h4>
                                            <a href="{{route('login')}}" class="btn-normal btn" type="submit">{{trans('home.Login')}}</a>
                                            <a href="{{route('register')}}" class="btn-normal btn" type="submit">{{trans('home.Register New Account')}}</a>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            </div>


                        </form>


                @else
                    <section class="bg-white section-big-py-space">

                        <div class="title3 ">
                            <h4>
                                {{trans('home.cart is empty')}}
                            </h4>
                            <br>
                            <a href="{{ URL::previous() }}" class="btn btn-danger btn-lg">{{trans('home.back')}}</a>
                        </div>
                        <!-- title end -->

                    </section>
                @endif
    @else
                    <section class="bg-white section-big-py-space">

                        <div class="title3 ">
                            <h4>
                                {{trans('home.Admin Can`t Checkout order')}}
                            </h4>
                            <br>
                            <a href="{{ URL::previous() }}" class="btn btn-danger btn-lg">{{trans('home.back')}}</a>
                        </div>
                        <!-- title end -->

                    </section>

                @endif
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
$("#cupon_submitter").click(function(){
  var id = $('#cupon_code').val();
  if(id !== ''){
    var url = '/cupon/apply/' + id;
    window.location = url;
  } else {
    $('#cupon_code').focus();
  }
});
</script>
<script>
window.onload = function() {
    var latlng = new google.maps.LatLng(30.0444, 31.2357);
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
    google.maps.event.addListener(marker, 'dragend', function(a) {
        console.log(a);
        var div = document.createElement('div');
        var lat = a.latLng.lat().toFixed(4);
        var lng = a.latLng.lng().toFixed(4);
        $('#lat_input').val(lat);
        $('#lng_input').val(lng);
    });
};
</script>
<script>

    $('#receive_from_location').on('change', function () {
        if ($(this).is(':checked')) {
            $('#location-container').show();
        } else {
            $('#location-container').hide();
        }
    });

    $('#send_to_home').on('change', function () {
        if ($(this).is(':checked')) {
            $('#location-container').hide();
        } else {
            $('#location-container').show();
        }
    });

    // Form Validation
    // var validationform=[]
    // function checkForm(isValid){
    //     console.log(isValid)
    //     if (!isValid) {
    //         validationform.push(true)
    //     }
    // }
    bootstrapValidate(['[name="first_name"]','[name="last_name"]'],'min:3: enter at least 3 char' )
    bootstrapValidate(['[name="phone"]'],'phone: enter valid phone')
    bootstrapValidate(['[name="email"]'],'email: enter valid mail')
    bootstrapValidate(['[name="state"]','[name="address"]'],'regex:^[a-zA-Z0-9 ]+$: enter valid address/state')
    bootstrapValidate('[name="postal_code"]','regex:^\\d{5}(-{0,1}\\d{4})?$: enter valid postal code')
    bootstrapValidate('[name="card_holder_name"]','regex:^[a-zA-Z0-9 ]+$: enter valid Credit card name')
    bootstrapValidate('[name="card_number"]','regex:^6(?:011\d{12}|5\d{14}|4[4-9]\d{13}|22(?:1(?:2[6-9]|[3-9]\d)|[2-8]\d{2}|9(?:[01]\d|2[0-5]))\d{10})$: enter valid credit card number')
    bootstrapValidate('[name="cvv"]','regex:^[0-9]{3,4}$: enter valid Card CVV')

    // $('#payInDelvired').click(function (evt) {
    //     evt.preventDefault();
    //     console.log('you are in payInDelvired')
    //     $('#dataToSaveOrderBefore').submit(function(event){
    //         console.log('successes dataToSaveOrderBefore>>>>>>')
    //         event.preventDefault();
    //     });
    // });

    first_nameInput = document.querySelector('[name="first_name"]')
    last_nameInput = document.querySelector('[name="last_name"]')
    phoneInput = document.querySelector('[name="phone"]')
    stateInput = document.querySelector('[name="state"]')
    addressInput = document.querySelector('[name="address"]')
    postal_codeInput = document.querySelector('[name="postal_code"]')
    card_holder_nameInput = document.querySelector('[name="card_holder_name"]')
    cvvInput = document.querySelector('[name="cvv"]')
    function validateForms() {
        return [
            first_nameInput,
            last_nameInput,
            phoneInput,
            stateInput,
            addressInput,
            postal_codeInput,
            card_holder_nameInput,
            cvvInput,
        ].every(validateInput)
    }
    function validateInput(input){
        return (
            input.value.length && input.value.length > 0
        );
    }

    $('#payfort_fort_pay_action').click(function (evt) {

        evt.preventDefault();

        console.log("validateForms()",validateForms())
        if(!validateForms()){
            card_holder_nameInput.focus()
            alert(" برجاء م الحقول")
            return;
        }

        let datapayfort = {};
        let paramsString = $("#dataToSaveOrderBefore").serialize();
        let mySearchParams = new URLSearchParams(paramsString);
        for (const [key, value] of mySearchParams) {
            datapayfort[key]=value
        };

        console.log( "datapayfort",datapayfort );

        $.post( "/payfortSaveOrder" ,  datapayfort , function( data ) {
            console.log( data ); // John
        }, "json").done(function( response ) {

            var $form = $('#payfort_fort_form');
            var form_elements = {};
            form_elements = $form.find('input:hidden').serialize();
            console.log(form_elements);
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "{{url('/payfortToken')}}",
                data: form_elements,
                success: function (response) {
                    if (response.form) {
                        $('body').append(response.form);
                        var expDate = $('#payfort_fort_expiry_year').val() + '' + $('#payfort_fort_expiry_month').val();
                        var mp2_params = {};
                        mp2_params.card_holder_name = $('#payfort_fort_card_holder_name').val();
                        mp2_params.card_number = $('#payfort_fort_card_number').val();
                        mp2_params.expiry_date = expDate;
                        mp2_params.card_security_code = $('#payfort_fort_cvv').val();
                        $.each(mp2_params, function (k, v) {
                            console.log(k +' - '+ v);
                            $('<input>').attr({
                                type: 'hidden',
                                id: k,
                                name: k,
                                value: v
                            }).appendTo('#payfort_final_payment_form');
                        });
                        $('#payfort_final_payment_form input[type=submit]').click();

                    } else {
                        console.log('Unable to contact server for payment processing');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        })


    });
</script>

@endsection
