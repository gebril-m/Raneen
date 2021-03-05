@extends('website.layouts.master')

@section('title',__('User.Order History'))

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
                          <h2>{{__('User.Order History')}}</h2>
                        </div>
                        <div class="table-responsive " >
                          <table class="table table-bordered cart_summary table-striped">

                            <thead style="background-color: #272727;color: white;">
                              <tr class="first last">
                                <th style="text-align: center;">{{__('Product.Order Id')}}</th>
                                <th style="text-align: center;">{{__('User.Date')}}</th>
                                <th style="text-align: center;">{{__('User.Product Name')}}</th>
                                <th style="text-align: center;"><span class="nobr">{{__('User.Order Total')}}</span></th>
                                <th style="text-align: center;">{{__('Product.status')}}</th>
                                <th style="text-align: center;">{{__('Product.Action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                            @if($orders->count() != 0)
                            @foreach($orders as $k => $order)
                            @php
                                $orderProducts = $order->products;
                                $orderRewardPoints = $orderProducts->sum('pivot.reward_points');
                                $orderRewardPoint = $orderProducts->sum('reward_points');
                            @endphp
                              <tr class="first odd">
                                <td style="text-align: center;">{{$order->id}}</td>
                                <td style="text-align: center;">{{$order->created_at}} </td>
                                <td style="text-align: center;">
                                    @php
                                        $totalCounter = 0;
                                    @endphp
                                    @if(count($orderProducts) > 0)
                                        @foreach($orderProducts as $product)
                                            @php
                                                $totalCounter += $product->pivot->price * $product->pivot->quantity;
                                            @endphp
                                            <span class="badge badge-info" style="color:black;background:none;border: 1px solid #b22827;border-radius:0">{{$product->name}}</span>
                                    @endforeach
                                    @endif

                                </td>
                                <td style="text-align: center;"><span class="price">${{$totalCounter}}</span></td>

                                <td style="text-align: center;"><em>{{isset($order->status)?$order->status->name:''}}</em></td>

                                    @if($order->status->name == 'preparing')
                                      <td class="last" style="text-align: center;">
                                    <span class="nobr btn btn-success">
                                        <a style="color: white" href="{{url('/'.$locale.'/order/history/'.$order->id)}}">{{__('User.View Order')}}</a>
                                    </span>
                                    <span class="nobr btn">
                                        <a style="color: white" href="{{url('/'.$locale.'/cancel_order/'.$order->id)}}">{{__('User.Cancel Order')}}</a>
                                    </span>
                                      </td>
                                  @else
                                      <td class="last " style="text-align: center;">
                                    <span class="nobr btn">
                                        <a style="color: white" href="{{url('/'.$locale.'/order/history/'.$order->id)}}">{{__('User.View Order')}}</a>
                                    </span>
                                      </td>
                                    @endif



                              </tr>
                              @endforeach
                              @endif


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
<script>
    $('.return_product').click(function(){
        var product = $(this).data('product');
        var order = $(this).data('order');
        var reason = $(this).parent('td').find('select').val();
        var return_col = $(this).parent('td');
        $.get('/order_update/'+product+'/'+order+'/'+reason, function(res){
            if(res == "true"){
                $.notify("Return Requested", "success");
                setTimeout(function(){
                    return_col.html('Return Requested');
                },100)
            }else{
                $.notify("There's something wrong", "danger");
            }
        })
    })
</script>

@endsection
