@extends('website.layouts.master')

@section('title',__('User.Wallet'))

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
            @include('website.users.sidebar')


                <div class="page-content col-xs-12 col-sm-8 col-md-9">
                  <div class="my-account">

                    <div class="dashboard">

                      <div class="recent-orders">
                        <div class="page-title" style="text-align: start;">
                          <h2>{{__('User.Wallet')}}</h2>
                        </div>


                        <div class="table-responsive " >
                          <table class="table table-bordered cart_summary table-striped">

                            <thead style="background-color: #272727;color: white;">
                              <tr class="first last">
                                <th style="text-align: center;font-size: 13px;">{{__('User.Amount')}}</th>
                                <th style="text-align: center;font-size: 13px;">{{__('User.Entry Date')}}</th>
                                <th style="text-align: center;font-size: 13px;">{{__('User.Notes')}}</th>


                              </tr>
                            </thead>
                            <tbody>
                                @if(count($wallets) > 0)

                                @foreach($wallets as $wallet)
                              <tr class="first odd">
                                <td style="text-align: center;font-size: 15px;">{{$wallet->amount}}</td>
                                <td style="text-align: center;font-size: 15px;">{{$wallet->created_at}}</td>
                                <td style="text-align: center;font-size: 15px;">{{$wallet->notes}}</td>


                              </tr>
                              @endforeach
                              @endif
                              <tr class="first odd">
                                <td style="text-align: center;font-size: 15px;" >{{$wallets->sum('amount')}} </td>
                                <td style="text-align: center;font-size: 15px;" >-</td>
                                <td style="text-align: center;font-size: 15px;" >-</td>


                            </tbody>
                          </table>
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
