@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Companies</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Companies</a></li>
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
                            'url' => route('admin.shipping_companies.store'), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_brand_form']) !!}

                        <section>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="fuel">Fuel:</label>
                                <input type="text" name="fuel" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="post">Post:</label>
                                <input type="text" name="post" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="vat">Vat:</label>
                                <input type="text" name="vat" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="cod">Cod:</label>
                                <input type="text" name="cod" class="form-control">
                            </div>
                        </section>
                        <section>
                            <div class="form-group">
                                <label for="weight">First Kg Number</label>
                                <input type="text" class="form-control" id="first_kg_number" name="first_kg_number">
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
