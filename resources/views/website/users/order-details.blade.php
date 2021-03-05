@extends('website.layouts.master')

@section('title',__('User.Order Details'))

@section('stylesheet')

@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')


  <!-- Main Container -->
  <section class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
      @include('website.users.sidebar')

        <div class="col-main col-sm-9 col-xs-12">
          <div class="my-account">

          <div class="page-title" style="text-align: start;">
                          <h2>{{trans('User.Order Details')}}</h2>
                        </div>
              <div class="row">

      @php
        $orderProducts = $orders->products;
        $orderRewardPoints = $orderProducts->sum('pivot.reward_points');
        $orderRewardPoint = $orderProducts->sum('reward_points');
    @endphp

      <!-- <h2 class="h2 mb-20 h-title"> {{trans('order.det')}}</h2> -->
                      <div class="col-xs-12" style="overflow: auto;">
                    <table class="table cart-table table-responsive-xs details-table" style="background: none ">
                        <thead  style="background:#272727; color: white;">
                        <tr class="table-head">
                            <th scope="col" style="text-align:center ;vertical-align: middle;">{{trans('Users.Product')}}</th>
                            <th scope="col" style="text-align:center ;vertical-align: middle;">{{trans('User.Description')}}</th>
                            <th scope="col" style="text-align:center ;vertical-align: middle;">{{trans('product.discounted price')}}</th>
                            <!-- <th scope="col" style="text-align:center ;vertical-align: middle;">{{trans('product.total price')}}</th> -->
                            <th scope="col" style="text-align:center ;vertical-align: middle;">{{trans('product.unit price')}}</th>
                            <th scope="col"style="text-align:center ;vertical-align: middle;">{{trans('product.Quantity')}}</th>
                            <th scope="col"style="text-align:center ;vertical-align: middle;">{{trans('product.total')}}</th>
                            <th scope="col" style="text-align:center ;vertical-align: middle;">{{trans('product.status')}}</th>
                            <!-- @if(isset($orders->status) and $orders->status->name == 'completed')
                            <th scope="col" style="text-align:center ;vertical-align: middle;">{{trans('product.return')}}</th>
                            @endif -->
                        </tr>
                        </thead>
                            @php
                                $totalCounter = 0;
                            @endphp
                            @if(count($orderProducts) > 0)
                                @foreach($orderProducts as $product)
                                    @php
                                        $totalCounter += $product->pivot->price * $product->pivot->quantity;
                                    @endphp
                                    <tbody>
                                    <tr>
                                        <td style="text-align:center ;vertical-align: middle;">
                                            <a href="{{$product->url}}"><img src="{{$product->thumbnail_url}}" alt="product" style="width: 50px; height: 50px" class="img-fluid  "></a>
                                        </td>
                                        <td style="text-align:center ;vertical-align: middle;">
                                            <a href="{{$product->url}}">
                                                {{ $product->name }}

                                            </a>
                                        </td>
                                        <td style="text-align:center ;vertical-align: middle;">
                                            {{ ($product->getFinalDiscountPriroty() != 0) ? $product->getFinalDiscountPriroty() : '-' }}
                                        </td>
                                        <!-- <td style="text-align:center ;vertical-align: middle;">
                                            {{$product->pivot->price * $product->pivot->quantity}}
                                        </td> -->
                                        <td style="text-align:center ;vertical-align: middle;">
                                            {{$product->pivot->price+$product->getFinalDiscountPriroty()}}
                                        </td>

                                        <td style="text-align:center ;vertical-align: middle;">
                                            <!-- <span>Size: L</span><br> -->
                                            <span> {{$product->pivot->quantity}}</span>
                                        </td>
                                        <td style="text-align:center ;vertical-align: middle;">
                                            {{$product->pivot->total}}
                                        </td>
                                        <td style="text-align:center ;vertical-align: middle;">
                                            <div class="responsive-data">
                                            @if($product->check_return($product->id,$orders->id) == 2)
                                              {{__('User.Refunded')}}
                                            @elseif($product->check_return($product->id,$orders->id) == 1)
                                              {{__('User.Return Request Sent')}}
                                            @else
                                              {{isset($orders->status)? $orders->status->name : ''}}
                                            @endif
                                            </div>
                                        </td>
                                        {{-- @if(isset($orders->status) and $orders->status->name == 'completed')
                                        <td style="text-align:center ;vertical-align: middle;">
                                            @if($product->check_return($product->id,$orders->id) == 1)
                                                {{__('User.Return Requests at')}} {{ $product->check_return_date($product->id,$orders->id) }}
                                            @elseif($product->check_return($product->id,$orders->id) == 2)
                                            {{__('User.Refunded')}}
                                            @else
                                            @if(count($product->categories) > 0)
                                                @if( $orders->get_product_return_policy($product->categories[0]['id'],$orders->created_at) == "false" )
                                                    <!-- <select class='form-control reason_select' style="-webkit-appearance: auto; -moz-appearance: auto;appearance: auto;margin:15px 0 ;width: 225px;">
                                                        <option value="0" style="width: 225px">- {{ __('User.Choose Reason') }} -</option>
                                                        @foreach($reasons as $reason)
                                                        <option value="{{$reason->id}}" style="width: 225px">{{$reason->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" class="form-control" name="bank_name" placeholder="{{__('User.Bank Name')}}">
                                                    <input type="text" class="form-control" name="bank_number" placeholder="{{__('User.Bank Number')}}">
                                                    <button class="return_product btn btn-danger" data-order="{{$orders->id}}" data-product="{{$product->id}}" style="width: 225px;">{{__('User.Return')}} </button>
                                                    </select> -->






                                                    <!-- modale control -->
                                                    <div class="modal fade" id="exampleModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">
                                                          <div class="modal-header" style="text-align: start;">
                                                            <h2 class="modal-title" id="exampleModalLabel" style="text-align: start;display: inline-block;color: black;font-weight: 600;">إلغاء الطلب</h2>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: black ; font-size: 30px;">
                                                              <span aria-hidden="true">&times;</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body" style="text-align: start;padding: 5px 15px;">
                                                          <h3 style="color: #b22827;"> {{__('User.Return Reason')}}</h3>
                                                          <!-- <ul>
                                                            <li>
                                                              <input type="checkbox" style="margin: 6px;"><span style="font-size:18px">تم التأخير عن الموعد المطلوب</span>
                                                            </li>
                                                            <li>
                                                              <input type="checkbox" style="margin: 6px;"><span style="font-size:18px">  المنتج غير مطابق للمواصفات  </span>
                                                            </li>
                                                            <li>
                                                              <input type="checkbox" style="margin: 6px;"><span style="font-size:18px">تم تغير رأي بشأن المنتج</span>
                                                            </li>
                                                            <li>
                                                              <input type="checkbox" style="margin: 6px;"><span style="font-size:18px">اسباب اخري </span>
                                                              <textarea name="" id=""  style="display: block;width: 100%; height: 100px;border-radius: 0;"></textarea>
                                                            </li>
                                                          </ul> -->
                                                          <select class='form-control reason_select' style="-webkit-appearance: auto; -moz-appearance: auto;appearance: auto;margin:15px 0 ;width: 225px;">
                                                            <option value="0" style="width: 100%">- {{ __('User.Choose Reason') }} -</option>
                                                            @foreach($reasons as $reason)
                                                            <option value="{{$reason->id}}" style="width: 100%">{{$reason->name}}</option>
                                                            @endforeach
                                                        </select>

                                                          </div>
                                                          <div class="modal-body" style="text-align: start;padding: 5px 15px;">
                                                            <h3 style="color: #b22827;" > {{__('User.Return Method')}}</h3>
                                                            <ul>
                                                              <li>
                                                                <input type="radio" style="margin: 6px;" name="return_method" value="1" checked><span style="font-size:18px">{{__('User.Refund to wallet')}}</span>
                                                              </li>

                                                            <li>
                                                              <input type="radio" style="margin: 6px;" name="return_method" value="2"><span style="font-size:18px"> {{__('User.Withdraw to bank')}} </span>
                                                              <span style="display: block; font-size: 18px; margin: 6px;"  >
                                                                <label for="">{{__('User.Bank Information')}}: </label>
                                                                <input type="text" class="form-control mb-1" name="bank_name" placeholder="{{__('User.Bank Name')}}" disabled="0" style="margin: 15px 0">
                                                                <input type="text" class="form-control" name="bank_number" placeholder="{{__('User.Bank Number')}}" disabled="0" style="margin: 15px 0">
                                                              </span>
                                                            </li>
                                                            </ul>

                                                          </div>
                                                          <div class="modal-footer" style="text-align: end;">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                            <button class="return_product btn btn-danger" data-order="{{$orders->id}}" data-product="{{$product->id}}" style="width: 225px;">{{__('User.Return')}} </button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!-- modale control -->



                                                    <button class="return_product btn btn-danger "  data-toggle="modal"    data-target="#exampleModal{{$product->id}}" type="button" data-order="{{$orders->id}}" data-product="{{$product->id}}" style="width: 225px;">{{__('User.Return')}} </button>
                                                    @else
                                                    {{__('User.Cannot Return')}}
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        @endif --}}
                                    </tr>
                                    </tbody>

                                @endforeach
                            @endif

                    </table>
                </div>
            </div>

              @php
                $orderProducts = $orders->products;
                $orderRewardPoints = $orderProducts->sum('pivot.reward_points');
                $orderRewardPoint = $orderProducts->sum('reward_points');
            @endphp

            <div class="orders-list table-responsive">
            <h2 style="color: #b22827">{{__('User.Order Information')}}</h2>

              <!--order info tables-->
              <table class="table table-bordered cart_summary table-striped">
                <tr>
                  <td class="order-number" style="text-align: start">{{__('User.Order Number')}}</td>
                  <td data-title="Order Number" style="text-align: start">#{{$orders->id}}</td>
                </tr>
                <tr>
                  <td class="order-number" style="text-align: start">{{__('User.Order Date')}}</td>
                  <td data-title="Order Date" style="text-align: start">{{$orders->created_at}}</td>
                </tr>
                <tr>

                  <td class="order-number" style="text-align: start">{{trans('product.status')}}</td>
                  <td data-title="Order Status" style="text-align: start">{{isset($orders->status)? $orders->status->name : ''}}</td>
                </tr>
                <tr>
                  <td class="order-number" style="text-align: start">{{__('User.Product Name')}}</td>
                  <td data-title="product name" style="text-align: start">
                      @php
                            $totalCounter = 0;
                        @endphp
                        @if(count($orderProducts) > 0)
                            @foreach($orderProducts as $product)
                                @php
                                    $totalCounter += $product->pivot->price * $product->pivot->quantity;
                                @endphp
                                <span class="badge badge-info "  style="color:black;background:none;border: 1px solid #b22827;border-radius:0">{{$product->name}}</span>
                        @endforeach
                        @endif
                    </td>
                </tr>

                  <td class="order-number" style="text-align: start">{{__('User.Total')}}</td>
                  <td data-title="Total" style="text-align: start"><p>${{$totalCounter}}</p></td>
                </tr>
              </table>
            </div>

            <div class="row">
              <div class="col-xs-12 col-md-12 col-sm12">

              <h2  style="color: #b22827">{{__('User.Bill To')}}</h2>

                <table class="table table-bordered cart_summary">
                  <tr>
                    <td style="text-align: start">{{trans('order.email')}}</td>
                    <td data-title="E-Mail" style="text-align: start" ><a href="mailto:{{$orders->email}}" class="color_dark">{{$orders->email}}</a></td>
                  </tr>

                  <tr>
                    <td style="text-align: start">{{trans('order.first name')}}</td>
                    <td data-title="First Name" style="text-align: start" >{{$orders->first_name}}</td>
                  </tr>
                  <tr>
                    <td style="text-align: start">{{trans('order.last name')}}</td>
                    <td data-title="Last Name" style="text-align: start" >{{$orders->last_name}}</td>
                  </tr>
                  <tr>
                    <td style="text-align: start">{{trans('order.address')}}</td>
                    <td data-title="Address 1"style="text-align: start" >{{$orders->address}}</td>
                  </tr>
                  <tr>
                    <td style="text-align: start">{{trans('order.postal code')}}</td>
                    <td data-title="Zip / Postal Code"  style="text-align: start">{{$orders->postal_code}}</td>
                  </tr>
                  <tr>
                    <td style="text-align: start">{{trans('order.state')}}</td>
                    <td data-title="state" style="text-align: start" >{{$orders->state}}</td>
                  </tr>

                  <tr>
                    <td style="text-align: start">{{trans('order.phone')}}</td>
                    <td data-title="Phone"style="text-align: start" >{{$orders->phone}}</td>
                  </tr>
                </table>
                <h2  style="color: #b22827">{{__('Product.Reviews')}}</h2>
                <div class="col-sm-5 col-lg-5 col-md-5">
                        <div class="reviews-content-left">
                          <div class="rating col-xs-12" style="padding: 30px 0; background-color: #b22827; margin-bottom: 5px;">
                            <span class="rating-num">

                            {{intval($product->scopeReviewsDetails()[0]['ratesCount'])}}

                              <!-- {{intval($product->scopeReviewsDetails()[0]['rateAvg'])}} -->
                            </span>

                            <div class="rating-stars" style="display: block;">
                              <div class="rating-stars">
                                @include('website.products.rating-template',[
                                  'avg'=>$product->getRateAvg()
                                ])
                              </div>
                            </div>
                            <div class="rating-users">
                              <i class="icon-user"></i> {{intval($product->scopeReviewsDetails()[0]['ratesCount'])}} {{__('Review.Total')}}
                            </div>
                          </div>
                          <h2>{{__('Product.Reviews')}}</h2>
                          @php
                          $product_reviews = $product->get_reviews();
                          @endphp
                          <div style="overflow-y:auto; overflow-x: hidden; height: 300px  ">
                          @foreach($product_reviews as $review)
                          <div class="review-ratting col-xs-12">
                            <p class="author" style="color: #b22827;font-size: 16px;"> {{ (isset($review->user)) ? $review->user->name : '' }}<span style="color: #999999; font-size: 12px;"> ({{__('Review.Posted On')}} {{$review->created_at}})</span> </p>
                            <P style="color: #333333;">{{$review->review_title}}</P>
                            <p style="color: gray;">{{$review->review}}</p>
                             <span ><div class="rating">

                              @include('website.products.rating-template',[

                                'avg'=>intval($review->rate)
                              ])
                            </div></span>
                          </div>
                          @endforeach
                          </div>
                          <!-- <div class="buttons-set">
                            <button class="button submit" title="Submit Review" type="submit"><span><i class="fa fa-angle-double-right"></i> &nbsp;view all</span></button>
                          </div> -->
                        </div>
                      </div>
                      <div class="col-sm-7 col-lg-7 col-md-7">

                        <div class="reviews-content-right row ">
                        <div class="col-xs-12" style="font-size: 15px;font-weight: 600;color: black;margin: 0  0  10px 0 ;">{{__('Review.Write Your Own Review')}}</div>



                          {{--  && !$product->userAlreadyReviewed --}}
                          @if(auth()->check())

                            <form action="/order/history/{{$product->id}}" method="post" id="review_form">
                              @csrf
                              <div class="table-responsive reviews-table col-xs-12">
                                <table>
                                  <tbody>
                                    <tr>
                                      <th></th>
                                      <th>1 {{__('Review.Star')}}</th>
                                      <th>2 {{__('Review.Star')}}</th>
                                      <th>3 {{__('Review.Star')}}</th>
                                      <th>4 {{__('Review.Star')}}</th>
                                      <th>5 {{__('Review.Star')}}</th>
                                    </tr>
                                    <tr>
                                      <td style="text-align: center;">{{__('Review.Rate')}}</td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="1" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="2" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="3" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="4" ></td>
                                      <td style="text-align: center;"><input type="radio" name="rating" value="5" ></td>
                                    </tr>


                                  </tbody>
                                </table>
                              </div>

                                <form class="form-row theme-form">

                                    <div class="form-area col-xs-12">
                                      <div class="form-element">
                                          <label for="review">{{trans('review.title')}}</label>
                                          <input type="text" class="form-control" name="title" id="review_title" required>
                                      </div>
                                      <div class="form-element">
                                          <label for="review">{{trans('review.body')}}</label>
                                          <textarea class="form-control" name="body" rows="6" id="review_body" required></textarea>
                                      </div>
                                      <div class="buttons-set">
                                          <button class="btn btn-normal" type="submit" id="submit_review_btn">{{trans('review.submit')}}</button>
                                      </div>
                                    </div>
                                    <input type="hidden" name="p_r_id" value="{{$product->id}}">
                            </form>
                        @else
                        <div class="col-xs-12" style="font-size: 15px;font-weight: 600;color: grey;text-align:center">{{__('Review.you must')}} <a href="{{url('/'.$locale.'/login')}}"  style="color: #b22827; text-decoration: underline;">{{__('Review.Login')}}</a> {{__('Review.To Write Review')}}</div>
                        @endif
                        </form>
                      </div>
                    </div>

{{--                <div class="ajax-checkout"> commented until there is a usage for it --}}
{{--                  <a href="{{ URL::previous() }}" title="Submit" class="btn button button-clear"> <span>{{trans('home.Back')}}</span></a>--}}
{{--                  @if(isset($orders->status) && in_array(strtolower($orders->status->name),$main_settings))--}}
{{--                    <a href="{{url('/cancel_order/'.$orders->id)}}" title="Submit" class="btn button button-clear"> <span>{{__('User.Cancel Order')}}</span></a>--}}
{{--                  @endif--}}
{{--                </div>--}}
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- service section -->

@include('website.components.footer')





@endsection

@section('javascript')
<script>
    $('input[name="return_method"]').change(function(){
      if($(this).val() == 2){
        $('input[name="bank_name"]').removeAttr('disabled');
        $('input[name="bank_number"]').removeAttr('disabled');
      }else{
        $('input[name="bank_name"]').attr('disabled','');
        $('input[name="bank_number"]').attr('disabled','');
      }
    })
    $('.return_product').click(function(){
        var product = $(this).data('product');
        var order = $(this).data('order');
        var reason = $(this).parents('.modal-content').find('select').val();
        var return_col = $(this).parent('td');
        var bank_name = $(this).parents('.modal-content').find('input[name="bank_name"]').val();
        var bank_number = $(this).parents('.modal-content').find('input[name="bank_number"]').val();
        console.log(bank_name);
        if(bank_name == ''){
          bank_name = "0";
        }
        if(bank_number == ''){
          bank_number = "0";
        }
        $.get('/order_update/'+product+'/'+order+'/'+reason+'/'+bank_name+'/'+bank_number, function(res){
            if(res == "true"){
                $.notify("Return Requested", "success");
                setTimeout(function(){
                  $('#exampleModal'+product).modal("hide");
                  $('.return_product').hide();
                    window.location.reload();
                    return_col.html('Return Requested');
                },100)
            }else{
                $.notify("There's something wrong", "danger");
            }
        })
    })
</script>

@endsection
