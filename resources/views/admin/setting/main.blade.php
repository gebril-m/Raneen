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
                        <li class="breadcrumb-item active">Main Setting</li>
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
                        <form action="{{ route('admin.setting.main_setting_post') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <label for="facebook_id">Facebook Client ID</label>
                                    <input type="text" class="form-control" name="facebook_id" value="{{$facebook_id}}">
                                </div>
                                <div class="col-6">
                                    <label for="facebook_secret">Facebook Client Secret</label>
                                    <input type="text" class="form-control" name="facebook_secret" value="{{$facebook_secret}}">
                                </div>
                                <div class="col-6">
                                    <label for="google_id">Google Client ID</label>
                                    <input type="text" class="form-control" name="google_id" value="{{$google_id}}">
                                </div>
                                <div class="col-6">
                                    <label for="google_secret">Google Client Secret</label>
                                    <input type="text" class="form-control" name="google_secret" value="{{$google_secret}}">
                                </div>
                                <div class="col-6">
                                    <label for="twitter_id">Twitter Client ID</label>
                                    <input type="text" class="form-control" name="twitter_id" value="{{$twitter_id}}">
                                </div>
                                <div class="col-6">
                                    <label for="twitter_secret">Twitter Client Secret</label>
                                    <input type="text" class="form-control" name="twitter_secret" value="{{$twitter_secret}}">
                                </div>
                                @if($settings->count() > 0)
                                    @foreach($settings as $setting)
                                    @if($setting->key == 'discount_priority')
                                    <div class="col-6">
                                        <label for="{{$setting->key}}">{{$setting->key}}</label>
                                        <select name="{{$setting->key}}" class="form-control">
                                            <option value="0">- Choose -</option>

                                            <option value="high_discount" @if($setting->value == 'high_discount') selected @endif>High Discount</option>

                                            <option value="low_discount" @if($setting->value == 'low_discount') selected @endif>Low Discount</option>

                                            <option value="old" @if($setting->value == 'old') selected @endif>Oldest</option>

                                            <option value="new" @if($setting->value == 'new') selected @endif>Newest</option>
                                        </select>
                                    </div>
                                    @else
                                        <div class="col-6">
                                            <label for="{{$setting->key}}">{{$setting->key}}</label>
                                            <input type="text" class="form-control" name="{{$setting->key}}" value="{{$setting->value}}">
                                        </div>
                                    @endif
                                    @endforeach
                                @endif
                            </div>
                            <button class="btn btn-success" type="submit">Save</div>
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
