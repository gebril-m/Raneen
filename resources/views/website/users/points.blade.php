@extends('website.layouts.master')

@section('title',__('User.User Points'))

@section('stylesheet')

@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')
  <!-- start login -->
  <main id="mainContent" class="main-content">
    <!-- Page Container -->
    <div class="page-container ptb-60">
        <div class="container">
            <div class="row row-rl-10 row-tb-20">
                @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
            @include('website.users.sidebar')


                <div class="page-content col-xs-12 col-sm-8 col-md-9">
                  <div class="my-account">

                    <div class="dashboard">

                      <div class="recent-orders">
                        <div class="page-title" style="text-align: start;">
                          <h2>{{__('User.Points')}}</h2>
                        </div>


                        <div class="table-responsive " >
                          <table class="table table-bordered cart_summary table-striped">

                            <thead style="background-color: #272727;color: white;">
                              <tr class="first last">
                              <th style="text-align: center;font-size: 13px;">{{__('User.Order Number')}}</th>
                              <th style="text-align: center;font-size: 13px;">{{__('User.Value')}}</th>

                                <th style="text-align: center;font-size: 13px;">{{__('User.Point')}}</th>
                                <td style="text-align: center;font-size: 15px;">{{__('User.Point Value')}}</td>



                              </tr>
                            </thead>
                            <tbody>
                                @if(count($points) > 0)
                                @foreach($points as $point)
                              <tr class="first odd">
                              <td style="text-align: center;font-size: 15px;">{{__('User.Order Number')}} #{{$point->order_id}}</td>
                              <td style="text-align: center;font-size: 15px;">{{$point->total}}</td>

                                <td style="text-align: center;font-size: 15px;">{{$point->points}}</td>
                                <td style="text-align: center;font-size: 15px;"> {{$point->convert_money($point->points)}}</td>

                              </tr>
                              @endforeach
                              @endif
                              <tr class="first odd">
                                <td style="text-align: center;font-size: 15px;">{{__('User.Total')}}</td>

                                <td style="text-align: center;font-size: 15px;" >{{$points->sum('total')}} </td>
                                <td style="text-align: center;font-size: 15px;" >{{$points->sum('points')}} </td>
                                <td style="text-align: center;font-size: 15px;">{{$money}}</td>



                              </tr>
                            </tbody>
                          </table>
                          <a href="{{url('/'.$locale.'/convert_points')}}" class="btn btn-success">{{__('User.Convert Points')}}</a>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Container -->


</main>
  <!-- end login -->

@include('website.components.footer')





@endsection

@section('javascript')

@endsection
