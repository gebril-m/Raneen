@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Zones</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Zones</a></li>
                        <li class="breadcrumb-item active">Create</li>
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body wizard-content">

                        {!! Form::open([
                            "enctype" => "multipart/form-data",
                            'url' => route('admin.shipping_zones.store'), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_brand_form']) !!}

                        <section>
                            <div class="form-group">
                                <label for="company_id">Company:</label>
                                <select name="company_id" class="select2 form-control">
                                    @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="zone_name">Zone Name:</label>
                                <input type="text" name="zone_name" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="areas">areas:</label>
                                <select class="js-example-basic-single form-control" name="areas[]" multiple="multiple">
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>
                                @error('areas')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="first_kg">First Kg:</label>
                                <input type="text" name="first_kg" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="additional_kg">Additional Kg:</label>
                                <input type="text" name="additional_kg" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="cod_values">Cod Values:</label>
                                <input type="text" name="cod_values" class="form-control">
                            </div>
                        </section>

                        <button type="submit" class="btn btn-success">Submit</button>

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
    <link rel="stylesheet" type="text/css" href="{{asset('admin-asset/assets/node_modules/select2/dist/css/select2.min.css')}}">

@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/select2/dist/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        $('.select2').select2();
</script>
@endsection
