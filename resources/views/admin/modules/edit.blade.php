@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Modules</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Modules</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Module Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body wizard-content ">
                        <h4 class="card-title">
                            Module Information
                        </h4>
                        <form enctype="multipart/form-data" action="{{ route('admin.modules.update', $row->id) }}" method="post" class="tab-wizard vertical wizard-circle">
                            <!-- Step Content -->
                            {{method_field('PUT')}}
                            {{csrf_field()}}

                            <section>
                                <div class="form-group">
                                    <label for="place">Place:</label>
                                    <input readonly type="text" id="place" name="place" class="form-control" value="{{ $row->place }}" />
                                </div>
                                <div class="form-group">
                                    <label for="order_id">Order:</label>
                                    <input type="number" step="1" id="order_id" name="order_id" class="form-control" value="{{ $row->order_id }}" />
                                </div>

                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info active">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="checkbox0" name="active"
                                            @if($row->is_active) checked @endif
                                            >
                                            <label class="custom-control-label" for="checkbox0">Module Active</label>
                                        </div>
                                    </label>
                                </div>

                                @if(View::exists('admin.modules.parts.' . $row->place))
                                    @include('admin.modules.parts.' . $row->place)
                                @endif

                                <br>
                                <hr>

                                <div class="row justify-content-center">
                                    <button type="submit" class="btn btn-success">SAVE</button>
                                </div>

                            </section>

                        </form>
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
    {{--    <script src="{{asset('admin-asset/assets/ckeditor4/ckeditor.js')}}"></script>--}}
    {{--    <script src="{{asset('admin-asset/assets/ckeditor4/sample.js')}}"></script>--}}


@endsection
@section('style')
@endsection
