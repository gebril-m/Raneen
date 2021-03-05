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
                        <form action="{{route('admin.setting.update',[$setting->id])}}" method="post">
                            {{csrf_field()}}
                            {{method_field('patch')}}

                            @foreach($setting->translations as $p)
                                @php $localeName = \App\Language::where('locale',$p->locale)->first()->name @endphp

                                <div class="form-group">
                                    <h4 for="location1">Name {{$localeName}} :</h4>
                                    <input type="text" name="name_{{$p->locale}}" class="form-control" value="{{$p->name}}" required>
{{--                                    <label for="name_{{$p->locale}}" generated="true" class="error text-danger"></label>--}}
                                </div>
                                <div class="form-group">
                                    <h4 for="location1">Description {{$localeName}} :</h4>
                                    <textarea name="description_{{$p->locale}}" class="form-control" required>{{$p->description}}</textarea>
{{--                                    <label for="description_{{$p->locale}}" generated="true" class="error text-danger"></label>--}}
                                </div>
                                <br>
                                <hr>
                                <br>
                            @endforeach
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
