<li class="main-menu-navs_list"><a href="{{url('/'.$locale)}}" class="dark-menu-item">{{trans('home.home')}}</a></li>
<li class="main-menu-navs_list"><a href="{{url('/'.$locale.'/search?specials=on_sale,up_selling&cat=all')}}" class="dark-menu-item">{{trans('home.offers')}}</a></li>
@foreach($category_header as $header)
    <li>
        <a href="{{url('/'.$locale.'/'.$header->slug.'/c')}}" class="dark-menu-item">{{$header->name}}</a>
    </li>
@endforeach
@foreach($page_header as $header)
    <li class="main-menu-navs_list">
        <a href="{{url('/'.$locale.'/'.$header->slug.'/page')}}" class="dark-menu-item">{{$header->name}}</a>
    </li>
    <!--PAGES-END-->
@endforeach
