@extends('website.layouts.master')

@section('title',__('User.User Complaints'))

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
                    <div class="page-title" style="text-align: start;margin-bottom: 20px;">
                        <h2>{{__('User.Complaints')}}</h2>
                    </div>
                    <!-- <div id="reviews" class="tab-pane" >
                        <div class="col-sm-5 col-lg-5 col-md-5">
                        <div class="reviews-content-left">
                            
                            <h2 >{{__('User.Complaint History')}}</h2>
                            @if(count($complaints) > 0)
                            @foreach($complaints as $complaint)
                            <div class="review-ratting">
                            <p class="author" style="color: #b22827;font-size: 16px;"> {{$complaint->get_user($complaint->from)->name}}<span style="color: #999999; font-size: 12px;"> ({{$complaint->created_at}})</span> </p>
                            <P style="color: #333333;">{{$complaint->title}}</P>
                            <p style="color: gray;">{{$complaint->body}} </p>

                            </div>
                            @endforeach
                            @endif
                        
                            
                        </div>
                        </div>
                        <div class="col-sm-7 col-lg-7 col-md-7">
                        
                        <div class="reviews-content-right row ">
                            <div class="col-xs-12" style="font-size: 15px;font-weight: 600;color: black;margin: 0  0  10px 0 ;">Write Your complaint </div>
                            
                            <form action="" method="post">
                                @csrf
                            <div class="form-area col-xs-12">
                                <div class="form-element">
                                <label>{{__('User.Summary')}}  <em>*</em></label>
                                <input type="text" name="title" style="width: 85%;height: 30px;">
                                </div>
                                <div class="form-element">
                                <label>{{__('User.Body')}}  <em>*</em></label>
                                <textarea name="body" style="width: 85%;height: 130px;"></textarea>
                                </div>
                                <div class="buttons-set">
                                <button class="button submit" title="Submit Review" type="submit"><span><i class="fa fa-thumbs-up"></i> &nbsp;send</span></button>
                                </div>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div> -->
                    <div class="messaging">
      <div class="inbox_msg">
       
        <div class="mesgs">
          <div class="msg_history">
          @if(count($complaints) > 0)
          @foreach($complaints as $complaint)
          @if($complaint->from == Auth::user()->id)
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>{{$complaint->body}}</p>
                <span class="time_date"> {{$complaint->created_at}}</span> </div>
            </div>
          @else
            <div class="incoming_msg">
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>{{$complaint->body}}</p>
                  <span class="time_date"> {{$complaint->created_at}}</span></div>
              </div>
            </div>
          @endif
          @endforeach
          @endif
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
            <form action="" method="post">
              @csrf
              <input type="hidden" class="write_msg" name="title" value="-" placeholder="Type a message" />
              <input type="text" class="write_msg" name="body" placeholder="Type a message" required />
              <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </form>
            </div>
          </div>
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