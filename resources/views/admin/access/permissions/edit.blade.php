@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Pages</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Pages</a></li>
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
                    <div class="card-body wizard-content ">
                        {!! Form::open(['url' => route('admin.permissions.update', $row->id)]) !!}
                            {{method_field('PUT')}}
                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', $row->name, ['class' => 'form-control']) }}
                                @error('name')
                                <span class="error text-danger"> {{$message}} </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{ Form::label('group_id', 'group') }}
                                {{ Form::select('group_id', $groups, $row->group_id, ['placeholder'=>'Select Group', 'class'=>'js-example-basic-single form-control']) }}
                                @error('group_id')
                                    <span class="error text-danger"> {{$message}} </span>
                                @enderror
                            </div>
                            <!-- <div class="form-group">
                                {{ Form::label('order', 'Order') }}
                                {{ Form::text('order', $row->order, ['class' => 'form-control']) }}
                                @error('order')
                                <span class="error text-danger"> {{$message}} </span>
                                @enderror
                            </div> -->
                            <div class="form-group">
                                {{ Form::submit('Submit', ['class' => 'btn btn-dark']) }}
                            </div>
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
    <!--alerts CSS -->
    <link href="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-asset/dist/css/custom.css')}}" rel="stylesheet">

    <!-- Theme included stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
@endsection
