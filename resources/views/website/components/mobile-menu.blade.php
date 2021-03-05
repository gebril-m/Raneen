<div id="mobile-menu">
    <ul>
      <li><a href="#" class="home1">Menu</a>
        <ul>
          <li><a href="{{url('/'.$locale)}}"><span>{{trans('home.home')}}</span></a></li>
          <li><a href="{{url('/'.$locale.'/search?specials=on_sale,up_selling&cat=all')}}"><span>{{trans('home.offers')}}</span></a></li>
          @if($category_header)
          @foreach($category_header as $header)
          <li><a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}"><span>{{$header->name}}</span></a></li>
          @endforeach
          @endif

          @foreach($page_header as $header)
          <li><a href="{{url('/'.$locale.'/'.$header->slug.'/page')}}"><span>{{$header->name}}</span></a></li>
          @endforeach
          
        </ul>
      </li>

      <li><a href="#">Category</a>
        <ul>
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
                  <ul>
                    @foreach($header->children as $child)
                    <li><a href="{{url('/'.$locale.'/'.$child->slug.'/c')}}">{{$child->name}} </a></li>
                    @endforeach
                  </ul>
                </li>

                @elseif($level == 3)

                <li><a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">{{$header->name}}</a>
                  <ul>
                    @foreach($header->children as $child)
                    <li><a href="{{url('/'.$locale.'/'.$child->slug.'/c')}}">{{$child->name}} </a>
                      <ul>
                        @foreach($child->children as $ch)
                        <li><a href="{{url('/'.$locale.'/'.$ch->slug.'/c')}}"><span>{{$ch->name}}</span></a></li>
                        @endforeach
                      </ul>
                    </li>
                    @endforeach
                  </ul>
                </li>

                @endif
              @endforeach
              @endif
              </ul>
        
      </li>

    </ul>
  </div>