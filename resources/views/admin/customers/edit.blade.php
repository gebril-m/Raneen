@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Users</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">users</a></li>
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

                        {!! Form::open(['url' => route('admin.customers.update', $row->id), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'edit_user_form']) !!}
                            {{ method_field('PUT') }}
                            <!-- sec section -->
                            <h6>Access Information</h6>
                            <section>

                                <div class="form-group">

                                    <label class="field-label">User Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$row->name}}">
                                    @error('name')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    
                                    <label class="field-label">Email Address</label>
                                    <input type="text" name="email" class="form-control" value="{{$row->email}}">
                                    @error('email')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>    
                                <div class="form-group">
                                    {{ Form::label('password', 'Password (Leave Empty If You Want To Keep Current)') }}
                                    {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
                                    <label for="password" generated="true" class="error text-danger"></label>
                                    @error('password')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    {{ Form::label('password_confirmation', 'Confirm Password') }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                    <label for="password_confirmation" generated="true" class="error text-danger"></label>
                                    @error('password_confirmation')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    {{ Form::checkbox('is_active', 1, $row->is_active) }}
                                    {{ Form::label('is_active', 'Check To Active User Access To Website') }}
                                </div>
                            </section>
                            <h6>User Information</h6>

                            <section>
                                <div class="form-group">
                                    
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ isset($row->details->first_name) ? $row->details->first_name : ''}}">
                                    @error('first_name')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>
                                <div class="form-group">
                                    
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{isset($row->details->last_name) ? $row->details->last_name : ''}}">
                                    @error('last_name')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>

                                <div class="form-group">
                                
                                <label class="field-label">Order Email Address</label>
                                                <input type="text" name="order_email" class="form-control" value="{{isset($row->details->email) ? $row->details->email : ''}}">
                                                @error('email')
                                                <span class="text-danger">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                            </div>


                                <div class="form-group">
                                    
                                    <label for="email" class="float-none">Gender</label> <br>
                                    <div class="card" style="border:1px solid #ced4da;border-radius:0;">
                                        <div class="card-body" style="padding:13px 25px;">
                                            <input type="radio" name="gender" value="m" {{ ($row->gender == 'm') ? 'checked' : ''}}> Male
                                            <input type="radio" name="gender" value="f" {{ ($row->gender == 'f') ? 'checked' : ''}}> Female
                                        </div>
                                    </div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                            
                                </div>

                                <div class="form-group">
                                    <label for="dob">Date Of Birth</label> <br>
                                    <input id="dob" type="date" class="form-control" name="dob" value="{{ $row->dob }}" autocomplete="dob">
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                            
                                </div>

                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label> <br>
                                    <input id="contact_number" type="number" class="form-control" name="contact_number" value="{{ $row->contact_number }}" autocomplete="contact_number">
                                    @error('contact_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror                            
                                </div>
                                
                                <div class="form-group">
                                    
                                    <label class="field-label">Phone</label>
                                    <input type="number" name="phone" class="form-control" value="{{isset($row->details->phone) ? $row->details->phone : ''}}">
                                    @error('phone')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>
                                <div class="form-group">
                                    
                                    <label class="field-label">Country</label>
                                    {{ Form::select('country_id', $countries, isset($row->details->country_id) ? $row->details->country_id : '', ['class'=>'form-control'])}}
                                    
                                    @error('country_id')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>                        
                                <div class="form-group">
                                    
                                    <label class="field-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{isset($row->details->address) ? $row->details->address : ''}}">
                                    @error('address')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>
                                <div class="form-group">
                                    
                                    <label class="field-label">Town/City</label>
                                    {{ Form::select('city_id', $cities, isset($row->details->city_id) ? $row->details->city_id : '', ['class'=>'form-control'])}}
                                    
                                    @error('city_id')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>
                                <div class="form-group">
                                    
                                    <label class="field-label">State / County</label>
                                    <input type="text" name="state" class="form-control" value="{{isset($row->details->state) ? $row->details->state : ''}}">
                                    @error('state')
                                    <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    
                                </div>
                                <div class="form-group">
                                    
                                    <label class="field-label">Postal Code</label>
                                    <input type="number" name="postal_code" class="form-control" value="{{isset($row->details->postal_code) ? $row->details->postal_code : ''}}">
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

@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script type="text/javascript">
        var form = $("#edit_user_form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                password_confirmation: {
                    equalTo: "#password"
                }
            }
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
</script>
@endsection
