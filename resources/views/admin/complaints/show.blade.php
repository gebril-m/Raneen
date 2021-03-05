@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Complaint</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Cities</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }} Complaints</li>
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
                <div class="card chat">
                    <div class="card-body" style="height: 60vh; overflow: auto;">
                        @if($chat->count() > 0)
                        @foreach($chat as $complaint)
                        <div class="container @if($complaint->to == Auth::user()->id) darker @endif">
                          <p>{{$complaint->body}}</p>
                          <span class="time-right">{{$complaint->created_at}}</span>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="card-body" style="height: 20vh; overflow: auto;">
                        <form action="" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="body" placeholder="Type message ..">
                                    <input type="hidden" name="to" value="{{$user->id}}"/>
                                    <input type="hidden" name="from" value="{{Auth::user()->id}}"/>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success w-100" type="submit">Send</button>
                                </div>
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
