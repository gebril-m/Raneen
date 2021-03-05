@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Settings</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Settings</a></li>
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
                    <div class="card-body">
                        <form action="{{ route('admin.priorty.store') }}" method="post">
                            {{csrf_field()}}

                        
                                <div class="form-group">
                                    <h4 for="location1">Name  :</h4>
                                    <input type="text" name="name" class="form-control" required>
                                    <label for="name" generated="true" class="error text-danger"></label>
                                    @error('name')
                                    <span class="text-danger">
                                        {{$message}}
                                         </span>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <h4 for="location1">Order Id</h4>
                                    <input type="number" name="order_id" class="form-control">
                                    <label for="" generated="true" class="error text-danger"></label>
                                    @error('order_id')
                                    <span class="text-danger">
                                        {{$message}}
                                         </span>
                                    @enderror

                                </div>
                                <br>
                                <hr>
                                <br>
                            
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>

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
    <link href="{{asset('admin-asset/dist/css/custom.css')}}" rel="stylesheet">
@endsection
