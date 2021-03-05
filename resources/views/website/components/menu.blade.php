<div class="col-md-9 col-sm-9 jtv-megamenu">
          <div class="mtmegamenu">
            <ul class="hidden-xs">
              
                <li class="mt-root">
                    <div class="mt-root-item">
                      <a href="{{url('/'.$locale)}}">
                        <div class="title title_font"><span class="title-text">{{trans('home.home')}}</span> </div>
                      </a>
                    </div>
                </li>
                
                {{-- Offers --}}
                <li class="mt-root">
                    <div class="mt-root-item">
                      <a href="{{url('/'.$locale.'/search?specials=on_sale,up_selling&cat=all')}}">
                        <div class="title title_font">
                            <span class="title-text">{{trans('home.offers')}}</span>
                        </div>
                      </a>
                    </div>
                </li>

                @foreach($dealsection_header as $deal)
                <li class="mt-root">
                    <div class="mt-root-item">
                      <a href="{{url('/'.$locale.'/dealsection/'.$deal->slug)}}">
                        <div class="title title_font">
                            <span class="title-text"style="color:yellow" >{{$deal->name}}</span>
                        </div>
                      </a>
                    </div>
                </li>
                @endforeach

                {{-- Category Header --}}
                @if($category_header)
                @foreach($category_header as $header)
                <li class="mt-root">
                    <div class="mt-root-item">
                    <a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}">
                        <div class="title title_font"><span class="title-text">{{$header->name}}</span> </div>
                    </a>
                    </div>
                </li>
                @endforeach
                @endif
                {{-- Page Header --}}
                @foreach($page_header as $header)
                <li class="mt-root">
                    <div class="mt-root-item">
                    <a href="{{url('/'.$locale.'/'.$header->slug.'/page')}}">
                        <div class="title title_font"><span class="title-text">{{$header->name}}</span> </div>
                    </a>
                    </div>
                </li>
                @endforeach
                
              
             
              
              
              
              <li><a href="https://templateforest.net/item/shopmart-electronic-digital-store-ecommerce-html-templates/20477712?s_rank=9"> </a></li>
            </ul>
          </div>
        </div>