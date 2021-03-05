<nav>
  <div class="container">
    <div class="row">
      <div class="mm-toggle-wrap">
        <div class="mm-toggle"><i class="fa fa-align-justify"></i> </div>
        <span class="mm-label">{{trans('home.Shop by category')}}</span> </div>
      <div class="col-md-3 col-sm-3 mega-container hidden-xs">
        <div class="navleft-container">
          <div class="mega-menu-title">
            <h3><span>{{trans('home.Shop by category')}}</span></h3>
          </div>

          <!-- Shop by category -->
          <div class="mega-menu-category noneis" style="display: none" >
            <ul class="nav">
              @if($categories)
                @foreach($categories as $header)
                  @if(count($header->children) > 0)
                    @foreach($header->children as $child)
                      @if(count($child->children) > 0)
                        @php $level= 3 @endphp
                        @break
                      @else
                        @php $level= 2 @endphp
                      @endif
                    @endforeach
                  @else
                    @php $level= 1 @endphp
                  @endif
                  @if($level == 1)
                    <li><a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">{{$header->name}}</a></li>
                  @elseif($level == 2)
                    <li><a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">{{$header->name}}</a>
                      <div class="wrap-popup">
                        <div class="popup">
                          <ul class="nav">
                              @foreach($header->children as $child)
                              <li><a href="{{url('/'.$locale.'/'.$child->slug.'/c')}}">{{$child->name}}x</a></li>
                              @endforeach
                          </ul>
                        </div>
                      </div>
                    </li>
                  @elseif($level == 3)
                    <li><a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">{{$header->name}}</a>
                      <div class="wrap-popup">
                        <div class="popup">
                          <div class="row">
                            @foreach($header->children as $child)
                            <div class="col-md-4 col-sm-6">
                              <h3><a href="{{url('/'.$locale.'/'.$child->slug.'/c')}}">{{$child->name}}</a></h3>
                              <ul class="nav">
                                  @foreach($child->children as $ch)
                                  <li><a href="{{url('/'.$locale.'/'.$ch->slug.'/c')}}">{{$ch->name}}</a></li>
                                  @endforeach
                              </ul>
                            </div>
                              @endforeach
                        </div>
                        </div>
                      </div>
                    </li>
                  @endif
                @endforeach
              @endif
            </ul>
          </div>
        </div>
      </div>


@include('website.components.menu')


</div>
</div>
</nav>