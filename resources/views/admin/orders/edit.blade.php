@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Orders</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Users</a></li>
                        <li class="breadcrumb-item active">create</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body wizard-content">

                        {!! Form::open(['url' => route('admin.orders.update', $order->id), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'edit_user_form']) !!}
                        {{ method_field('PUT') }}

                            <!-- sec section -->
                            <h6>Products Information</h6>
                            <section>

                                <div id="czContainer">

                                    <div id="first">
                                        <div class="recordset">
                                            <div class="row">
                                            <div class="col-4">
                                                <select name="products[]" class="form-control select2" id="products_select" required> 
                                                    <option value="">--please choose Product--</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->id}}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4" id="attributes_select">
                                                <i>Choose Product First</i>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="quantities[]" placeholder="Quantity" class="form-control" required>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- current order products -->
                                    @foreach($order->products as $op)
                                    @php $attrs = explode(',',$op->pivot->attribute_id) @endphp
                                    @foreach($attrs as $attr)
                                        <div class="recordset">
                                            <div class="row">
                                            <div class="col-4">
                                                <select name="products[]" class="form-control select2" id="products_select" required> 
                                                    <option value="">--please choose Product--</option>
                                                    @foreach($products as $p)
                                                        <option value="{{$p->id}}" {{ ($op->id == $p->id) ? 'selected' : '' }}>{{ $p->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4" id="attributes_select">
                                                <select name="attributes[]" class="form-control" id="products_select"> 
                                                    <option value="">--please choose Product--</option>
                                                    @foreach($attributes as $a)
                                                        <option value="{{$a->id}}" {{ ($attr == $a->id) ? 'selected' : '' }}>{{ $a->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="quantities[]" placeholder="Quantity" value="{{ $op->pivot->quantity }}" class="form-control" required>
                                            </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endforeach

                                </div>
                                
                            </section>

                            <h6>Order Information</h6>
                            <section>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{$order->first_name}}" required>
                                @error('first_name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{$order->last_name}}" required>
                                @error('last_name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="field-label">Phone</label>
                                <input type="number" name="phone" class="form-control" value="{{$order->phone}}" required>
                                @error('phone')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="field-label">Email Address</label>
                                <input type="text" name="email" class="form-control" value="{{$order->email}}" required>
                                @error('email')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                                <label class="field-label float-none">{{trans('home.Map location')}}</label> <br>
                                                <div id="map" style="height: 200px;border: 1px solid #000;"></div>
                                                <input type="hidden" id="lat_input" name="lat" value="{{$order->lat}}">
                                                <input type="hidden" id="lng_input" name="lng" value="{{$order->lng}}">
                                            </div>
                            <div class="form-group">
                                <label class="field-label">Country</label>
                                {{ Form::select('country_id', ['egypt', 'turkey'], isset($user->country_id) ? $user->country_id : '', ['class'=>'form-control', 'required' => 'required'])}}
                                <!-- {{ Form::select('country_id', $countries)}} -->
                                @error('country_id')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="field-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{$order->address}}" required>
                                @error('address')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="field-label">Town/City</label>
                                {{ Form::select('city_id', ['cairo', 'alex'],  isset($user->city_id) ? $user->city_id : '', ['class'=>'form-control', 'required' => 'required'])}}
                                <!-- {{ Form::select('city_id', $cities)}} -->
                                @error('city_id')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="field-label">State / County</label>
                                <input type="text" name="state" class="form-control" value="{{$order->state}}" required>
                                @error('state')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="field-label">Postal Code</label>
                                <input type="number" name="postal_code" class="form-control" value="{{$order->postal_code}}" required>
                                @error('postal_code')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                                
                                
                            </section>

                            
                        {!! Form::close() !!}

                    </div>

                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
@endsection
@section('style')

    <link href="{{asset('admin-asset/assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
    <link href="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-asset/dist/css/custom.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />


@endsection
@section('scripts')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin-asset/dist/js/jquery.czMore.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

    

    <script type="text/javascript">
        var form = $("#edit_user_form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); }
        });
        form.steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: "Submit"
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                form.submit();
            }
        });
        $("#czContainer").czMore(
            {
                styleOverride:true,
                onAdd: function(index) {
                    $('.select2').select2();
	            },
            }
        );
        $(document).on('change', '#products_select', function(){
            var self = $(this);
            var id = self.children("option:selected").val();
            $.ajax({
            url: '{{ route('admin.products.attributes') }}',
            data: {id: id}
            }).done(function(data){
                console.log(data);
                if(data !== '0'){
                    self.closest('.recordset').find('#attributes_select').html(data);
                } else {
                    self.closest('.recordset').find('#attributes_select').html('<input type="hidden" name="options_values[]" value="">');
                }
            });

        });
</script>
<script>
window.onload = function() {
    var latlng = new google.maps.LatLng({{ (empty($order->lat)) ? 30.0444 : $order->lat }}, {{ (empty($order->lng)) ? 31.2357 : $order->lng }});
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
@endsection
