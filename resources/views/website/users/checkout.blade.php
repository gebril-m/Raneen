@extends('website.layouts.master')

@section('title',__('User.Checkout'))

@section('stylesheet')

@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')
@if($nproducts['totalPrice'] == 0)
	<div class="my-5 alert alert-danger">
		{{__('Checkout.Add Products First')}}
	</div>
@else
<main id="mainContent" class="main-content">
    <!-- Page Container -->
    <div class="page-container ptb-60">
        <div class="container">
            <div class="row row-rl-10 row-tb-20">
            	@if(Auth::user())
                <div class="page-content col-xs-12 col-sm-8 col-md-9">

                    <!-- Checkout Area -->
                    <section class="section checkout-area panel prl-30 pt-20 pb-40">
                        <form name="checkout_form" method="post" action="{{route('web.checkout.send')}}" id="dataToSaveOrderBefore"class="mb-30">
                        	@csrf
	                    	<div class="steps step1">

	                        	<h2 class="h2 mb-20 h-title"> <div class="steps-number">1</div>{{__('User.Billing Information')}}</h2>
								@if(Auth::check())
								{{--<input type="hidden" name="company_id" value="{{$nproducts['company_id']}}"/>
								<input type="hidden" name="zone_id" value="{{$nproducts['zone_id']}}"/>--}}
								<input type="hidden" name="shipping_amount" value="{{$nproducts['totalShipping']}}"/>
	                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label>{{trans('home.First Name')}}</label>
	                                <input type="text"  name="first_name" value="{{ isset($user->first_name) ? $user->first_name : ''}}" class="form-control" required="">
	                                @error('first_name')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>
	                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label>{{trans('home.Last Name')}}</label>
	                                <input type="text" name="last_name" value="{{ isset($user->last_name) ? $user->last_name : ''}}" class="form-control" required="">
	                                @error('last_name')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>
	                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label class="field-label">{{trans('User.Phone')}}</label>
	                                <input type="number" name="phone" value="{{ isset($user->phone) ? $user->phone : ''}}" class="form-control" required="">
	                                @error('phone')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>
	                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label class="field-label">{{trans('home.Email Address')}}</label>
	                                <input type="text" name="email" value="{{ isset($user->email) ? $user->email : ''}}" class="form-control" required="">
	                                @error('email')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>

	                            <div class="form-group col-md-12 col-sm-12 col-xs-12" style="display: none">
	                                <label class="field-label float-none">{{trans('home.Map location')}}</label> <br>
	                                <div id="map" style="height: 300px;border: 1px solid #000;"></div>
	                                <input type="hidden" id="lat_input" name="lat" required="">
	                                <input type="hidden" id="lng_input" name="lng" required="">
	                            </div>

	                            <div class="form-group col-md-6 col-sm-6 col-xs-12 form-edit country-select">
	                                <label class="field-label">{{trans('home.Country')}}</label>
									<select name="country_id" id="country_id" class="form-control">
										<option value="">- {{__('User.Country')}} -</option>
									@foreach($countries as $country)
										<option value="{{$country->id}}" @if(isset($user['country_id']) && $user['country_id'] == $country->id) selected @endif >{{$country->name}}</option>
									@endforeach
									</select>
	                                @error('country_id')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
								</div>
	                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label class="field-label">{{trans('home.Town/City')}}</label>
	                                <select name="city_id" id="city_id" class="form-control">
										<option value="">- {{__('User.City')}} -</option>
									@foreach($cities as $city)
										<option value="{{$city->id}}" @if(isset($user['city_id']) && $user['city_id'] == $city->id) selected @endif data-country="{{$city->country_id}}">{{$city->name}}</option>
									@endforeach
									</select>
	                                @error('city_id')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>
	                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label class="field-label">{{trans('home.Address')}}</label>
	                                <input type="text" name="address" value="{{ isset($user->address) ? $user->address : ''}}" class="form-control" required="">
	                                @error('address')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>
								<div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label class="field-label">{{trans('home.State / County')}}</label>

	                                <select name="state" id="state_id" class="form-control">
										<option value="">- {{__('User.State')}} -</option>
									@foreach($states as $state)
										<option value="{{$state->id}}" @if(isset($user['state']) && $user['state'] == $state->id) selected @endif data-city="{{$state->city_id}}">{{$state->name}}</option>
									@endforeach
									</select>
	                                @error('state')
	                                <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>

	                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                <label class="field-label">{{trans('home.Postal Code')}}</label>
	                                <input type="number" name="postal_code" value="{{ isset($user->postal_code) ? $user->postal_code : ''}}" class="form-control" required="">
	                                @error('postal_code')
	                                    <span class="text-danger">
	                                        {{ $message }}
	                                    </span>
	                                @enderror
	                            </div>
	                            @else
									<div class="per">
	                                    <h4>
	                                       {{trans('home.To Continue Checkout Process Please Do The Following')}}
	                                    </h4>
	                                    <a href="{{route('login')}}" class="btn-normal btn" type="submit" style="margin:10px;width:200px;background-color:black">{{trans('home.Login')}}</a>
	                                    <a href="{{route('register')}}" class="btn-normal btn" type="submit"  style="margin:10px;width:200px;background-color:#337ab7 ">{{trans('home.Register New Account')}}</a>
	                                </div>
	                            @endif
							</div>
	                    	<div class="steps step2 hide-step">
	                        	<h2 class="h2 mb-20 h-title"> <div class="steps-number">2</div>{{__('User.Shipping method')}}</h2>
	                        	@if(Auth::check())
								      <div class="group">
								        <h3>{{__('User.shipping to my delivery address')}} </h3>
								        <div class="row">
								        	<div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                        <div class="form-check">
	                                            <input class="form-check-input" type="radio" name="ship_to" id="send_to_home" value="home" checked>
	                                            <label class="form-check-label mx-3" for="send_to_home">التوصيل الي المنزل</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
	                                        <div class="form-check">
	                                            <input class="form-check-input" type="radio" name="ship_to" id="receive_from_location" value="location">
	                                            <label class="form-check-label mx-3" for="receive_from_location">استلام من الفرع</label>
	                                        </div>
	                                    </div>
	                                    <div class="form-group col-md-12" style="display: none" id="location-container">
	                                        <select name="location_id" id="location_id">
												<option value="">- {{ __('User.Choose Location') }} -</option>
	                                            @foreach(\App\Location::all() as $location)
	                                                <option value="{{ $location->id }}">{{ $location->location }}</option>
	                                            @endforeach
	                                        </select>
	                                    </div>
								        </div>
								      </div>
	                            @else
								<div class="per">
	                                    <h4>
	                                       {{trans('home.To Continue Checkout Process Please Do The Following')}}
	                                    </h4>
	                                    <a href="{{route('login')}}" class="btn-normal btn" type="submit" style="margin:10px;width:200px;background-color:black">{{trans('home.Login')}}</a>
	                                    <a href="{{route('register')}}" class="btn-normal btn" type="submit"  style="margin:10px;width:200px;background-color:#337ab7 ">{{trans('home.Register New Account')}}</a>
	                                </div>
	                            @endif
							</div>
	                    	<div class="steps step3 hide-step">
	                        	<h2 class="h2 mb-20 h-title" ><div class="steps-number">3</div>{{__('User.Payment Information')}}</h2>
	                        	@if(Auth::check())
								      <div class="row">
								      	<div id="payfort_fort_form">
									        <label style="display: block; font-size: 18px;">
									          <input type="radio" name="radio1" value="credit">
									          {{__('User.Credit or Debit Cards')}} </label>
									          	<div class="col-md-6">
									          		<div class="form-group">
													    <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_card_holder_name" >{{__('User.Name On Card')}}</label>
													    <div class="large-12 medium-12 small-12 column">
													        <input type="text" class="form-control in-style" id="payfort_fort_card_holder_name" name="card_holder_name" value="" placeholder="Name on card" maxlength="50" minlength="3">
													    </div>
												    </div>
									          	</div>
									          	<div class="col-md-6">
												    <div class="form-group">
													    <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_card_number">{{__('User.Card Number')}}</label>
													    <div class="large-12 medium-12 small-12 column">
													        <input type="text" class="form-control in-style" id=
													        "payfort_fort_card_number" name="card_number" value="" placeholder="Credit card number" maxlength="16" minlength="14">
													    </div>
												    </div>
									          	</div>
											    <div class="col-md-4">
											        <div class="form-group m-2">
											            <label >{{__('User.Expiry Month')}} *</label>
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
											    <div class="col-md-4">
											        <div class="form-group m-2">
											            <label >{{__('User.Expiry Year')}} *</label>
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
											    <div class="col-md-4">
											    	<div class="form-group">
											    		<label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_cvv">{{__('User.Card CVV')}}</label>
													    <div class="large-7 medium-7 small-7 column">
													        <input  type="text" class="form-control in-style" id="payfort_fort_cvv" name="cvv" value="" placeholder="CVV" maxlength="4">
													    </div>
											    	</div>
											    </div>
											</div>
									    </div>
								          <label style="display: block; font-size: 18px; margin-bottom: 20PX;">
								            <input type="radio" name="radio1" value="cod">
											{{__('User.Cash On Delivery')}} </label>
											@if($wallet > $nproducts['totalPrice']+$nproducts['totalShipping'])
								          <label style="display: block; font-size: 18px; margin-bottom: 20PX;">
								            <input type="radio" name="radio1" value="wallet">
											{{__('User.Use Wallet Balance')}} {{$wallet}}</label>
											@endif
	                            @else
								<div class="per">
	                                    <h4>
	                                       {{trans('home.To Continue Checkout Process Please Do The Following')}}
	                                    </h4>
	                                    <a href="{{route('login')}}" class="btn-normal btn" type="submit" style="margin:10px;width:200px;background-color:black">{{trans('home.Login')}}</a>
	                                    <a href="{{route('register')}}" class="btn-normal btn" type="submit"  style="margin:10px;width:200px;background-color:#337ab7 ">{{trans('home.Register New Account')}}</a>
	                                </div>
	                            @endif
							</div>
							<div class="col-md-12">
							    <div class="large-5 medium-5 small-5 column text-center">

								<a href="#" class="btn btn-lg btn-rounded  back-step" data-step="1"  style="background:black; margin :10px;width:200px">{{__('User.Back Step')}}</a>
		                        	<a href="#" class="btn btn-lg btn-rounded  next-step" data-step="1" style="background:green; margin :10px;width:200px">{{__('User.Continue')}}</a>
							        <input type="submit" id="payfort_fort_pay_action" class="btn btn-lg btn-rounded  hide-step" value="{{__('User.Pay')}}"  style="background:green; margin :10px;width:200px">
			                        <a href="{{url('/'.$locale.'/')}}" class="btn btn-lg btn-warning btn-rounded" style="background:#b22827; margin :10px;;width:200px" >{{__('User.Cancel Order')}}</a>
								</div>
							</div>
                        </form>
                        <form id="payfort_final_payment_form"></form>
                    </section>
                    <!-- End Checkout Area -->

                </div>
                <div class="page-sidebar col-xs-12 col-sm-4 col-md-3">

                    <!-- Blog Sidebar -->
                    <aside class="sidebar blog-sidebar">
                        <div class="row row-tb-10">
                            <div class="col-xs-12">
                                <!-- Recent Posts -->
                                <div class="widget checkout-widget panel p-20">
                                    <div class="widget-body">
                                        @if(session()->has('message'))
                                            <span class="badge badge-info">
                                                {{ session()->get('message') }}
                                            </span>
                                        @endif
                                        <input type="text" name="cupon_code" placeholder="insert cupon code" class="form-control" id="cupon_code" value="{{ old('cupon_code') }}" style="margin-bottom: 10px"><button class="btn btn-info btn-block btn-sm" id="cupon_submitter">{{trans('home.Click To Apply Coupon')}}</button><table class="table mb-15">
										@if($points > 0)
										<div>
											<span style="display: block; margin:15px 0 ; font-size:14px">{{__('User.Total Points')}} <span>@if($points) {{$points}} @endif </span></span>
										</div>
										@if($wallet > 0)
										<div>
											<span style="display: block; margin:15px 0 ; font-size:14px">{{__('User.Total Wallet Balance')}} <span>@if($wallet) {{$wallet}} @endif </span></span>
										</div>
										@endif
										@endif
                                                @if($points > 0)
										<a class="btn btn-info btn-block btn-sm" id="cupon_submitter" href="{{url('/'.$locale.'/user/points')}}">{{trans('home.use.points')}}</a><table class="table mb-15">
                                                    @endif
                                            <tbody>
                                                <tr>

                                                    <td class="color-mid" style="text-align: start">{{__('User.Total products')}}</td>
                                                    <td style="text-align: center">{{ $cartDetails_counter }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="color-mid" style="text-align: start">{{__('User.Shipping')}}</td>
                                                    <td style="text-align: center">{{$nproducts['totalShipping']}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="color-mid" style="text-align: start">{{__('User.Total Tax')}}</td>
                                                    <td style="text-align: center">-</td>
                                                </tr>
                                                @if($totalCheckoutDiscount != 0)
                                                <tr class="font-15">
                                                    <td class="color-mid" style="text-align: start">{{trans('home.Discount')}}</td>
                                                    <td class="color-green" style="text-align: center">{{ $totalCheckoutDiscount }}</td>
                                                </tr>
                                                <tr class="font-15">
                                                    <td class="color-mid" style="text-align: start">{{trans('home.Total Price')}}</td>
                                                    <td class="color-green"style="text-align: center">{{ $totalCheckoutPrice }}</td>
                                                </tr>
                                                @else
                                                <tr class="font-15">

                                                    <td class="color-mid" style="text-align: start">{{__('User.Total')}}</td>
                                                    <td class="color-green"style="text-align: center">{{ $totalCheckoutPrice }}</td>
                                                </tr>
                                                @endif
                                                <tr>


                                              </tr>
                                            </tbody>
                                        </table>
                                        <a href="{{url('/'.$locale.'/cart')}}" class="btn btn-info btn-block btn-sm">{{__('User.Edit Cart')}}</a>
                                    </div>
                                </div>
                                <!-- End Recent Posts -->
                            </div>
                        </div>
                    </aside>
                    <!-- End Blog Sidebar -->
                </div>
                @else
                <div class="col-md-12 text-center"><div class="per">
                    <h4>
                       {{trans('home.To Continue Checkout Process Please Do The Following')}}
                    </h4>
                    <a href="{{route('login')}}" class="btn-normal btn" type="submit" style="margin:10px;width:200px;background-color:black">{{trans('home.Login')}}</a>
                    <a href="{{route('register')}}" class="btn-normal btn" type="submit"  style="margin:10px;width:200px;background-color:#337ab7 ">{{trans('home.Register New Account')}}</a>
                </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End Page Container -->


</main>
@endif

@include('website.components.footer')





@endsection

@section('javascript')

@endsection
