@extends('website.layouts.master')

@section('title',$search)

@section('stylesheet')
    
@endsection

@section('content')



@include('website.components.header')
@include('website.components.nav-sub')
@include('website.components.breadcrumb')



  <div class="main-container col2-left-layout">
    <div class="container">
      <div class="row">
      <aside class="sidebar col-sm-3 col-xs-12 " style="padding: 30px 15px ;background-color: #b22827; border-radius:15px ;margin-bottom: 15px" >
          @if(count($products) > 0)
          <div class="block shop-by-side">
            <div class="sidebar-bar-title" style="background-color: #272727;" >
              <h3 style="font-size:18px;color:#ffffff">{{__('Product.Shop By')}}</h3>
            </div>
            <form action="" method="get">
            @csrf
            <div class="block-content" style="background-color: #272727;" >
              <p class="block-subtitle" style="font-size:16px;color:#ffffff">{{__('Product.Shopping Options')}}</p>
              <div class="manufacturer-area" style="display: none">
                <h2 class="saider-bar-title cole" style="padding: 15px;color:white">{{__('Product.Manufacturer')}}</h2>
                <div class="saide-bar-menu content">
                  <ul>
                    @foreach($manufacturers as $item)
                    <li><a href="#" class="wh-f"><input type="checkbox" name="manufacturers_change" value="{{$item->id}}"> {{$item->name}}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="manufacturer-area">
                <h2 class="saider-bar-title cole" style="padding: 15px;">{{__('Product.Brands')}}</h2>
                <div class="saide-bar-menu content">
                  <ul class="brands">
                    @foreach($brands as $item)
                    @if(isset($_GET['filter']))
                    @php($filters = explode(',',$_GET['filter']))
                    @if (in_array($item->name,$filters))
                    <li><a  class="wh-f" href="#"><input type="checkbox" name="brands_change" value="{{$item->id}}" checked> {{$item->name}}</a></li>
                    @else
                    <li><a class="wh-f"  href="#"><input type="checkbox" name="brands_change" value="{{$item->id}}"> {{$item->name}}</a></li>
                    @endif
                    @else
                    <li><a  class="wh-f" href="#"><input type="checkbox" name="brands_change" value="{{$item->id}}"> {{$item->name}}</a></li>
                    @endif
                    @endforeach
                  </ul>
                </div>
              </div>

              @if(count($attrs_groups) > 0)      
              @foreach($attrs_groups as $group)
              <div class="manufacturer-area">
                <h2 class="saider-bar-title cole" style="padding: 15px;">{{$group->name}}</h2>
                <div class="saide-bar-menu content">
                  <ul class="attrs">
                    @if(count($attrs) > 0)
                      @foreach($attrs as $attr)
                      @if($group->attr($group->id,$attr->id) != "")
                        <li><a class="wh-f"  href="#"><input type="checkbox" name="attrs_change" value="{{$group->attr($group->id,$attr->id)['id']}}"> {{$group->attr($group->id,$attr->id)['name']}}</a></li>
                        @endif
                          
                      @endforeach
                    @endif
                  </ul>
                </div>
              </div>
              @endforeach
              @endif

            </div>
          </div>
          <div class="block product-price-range">
            <div class="sidebar-bar-title" >
              <h3 style="font-size:18px; color:white">{{__('Product.Price')}}</h3>
            </div>
            <div class="block-content">
              <div class="row">
                <div class="col-md-6">
                  <input type="number" class="form-control" name="min-price" value="{{$prices_obj[0]}}" min="0" max="{{$prices_obj[1]}}" style="margin-bottom: 5px">
                </div>
                <div class="col-md-6">
                  <input type="number" class="form-control" name="max-price" value="{{$prices_obj[1]}}" min="0" max="{{$prices_obj[1]}}" style="margin-bottom: 5px">
                </div>
              </div>
              <div class="slider-range" style="display: none">
                <div data-label-reasult="Range:" data-min="{{$prices_obj[0]}}" data-max="{{$prices_obj[1]}}" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="50" data-value-max="350"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 10%; width: 60%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 10%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 70%;"></span></div>
                <div class="amount-range-price">السعر: {{$prices_obj[0]}} - {{$prices_obj[1]}}</div>
                <ul class="check-box-list">
                  <li>
                    <input type="checkbox" id="p1" name="cc">
                    <label for="p1"> <span class="button"></span> 20{{__('product.currency')}} - 50{{__('product.currency')}}<span class="count">(0)</span> </label>
                  </li>
                  <li>
                    <input type="checkbox" id="p2" name="cc">
                    <label for="p2"> <span class="button"></span> 50{{__('product.currency')}} - 100{{__('product.currency')}}<span class="count">(0)</span> </label>
                  </li>
                  <li>
                    <input type="checkbox" id="p3" name="cc">
                    <label for="p3"> <span class="button"></span> 100{{__('product.currency')}} - 250{{__('product.currency')}}<span class="count">(0)</span> </label>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          @endif
          <input type="hidden" name="brands_filter">
          <input type="hidden" name="category_id" value="{{$category->id}}">
          <!-- <input type="submit" value="{{__('Product.Search')}}" class="btn btn-normal w-100"> -->
        </form>
        </aside>
        <div class="col-main col-sm-9 col-xs-12 ">
          <div class="category-description std" style="display: none;">
            <div class="slider-items-products">
              <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col1 owl-carousel owl-Template owl-theme" style="opacity: 1; display: block;"> 
                  
                  <!-- Item -->
                  <div class="owl-wrapper-outer"><div class="owl-wrapper" style="width: 1744px; right: 0px; direction: rtl; display: block; transition: all 1000ms ease 0s; transform: translate3d(0px, 0px, 0px);">
                    <div class="owl-item" style="width: 872px;">
                      <div class="item">
                        <a href="#"><img alt="HTML template" src="{{ image('category', $category->banner) }}"></a>
                        <div class="inner-info" style="display: none">
                          <div class="cat-img-title"> <span>Best Product 2017</span>
                            <h2 class="cat-heading">Best Selling Brand</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                            <a class="info" href="#">Shop Now</a> </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
                  <!-- End Item --> 
                  
                  <!-- Item -->
                  
                  
                  <!-- End Item --> 
                  
                <div class="owl-controls clickable"><div class="owl-buttons"><div class="owl-prev"><a class="flex-prev"></a></div><div class="owl-next"><a class="flex-next"></a></div></div></div></div>
              </div>
            </div>
          </div>
          <div class="shop-inner">
            <div class="page-title">
              <h2>{{$search}}</h2>
            </div>
            <div class="toolbar" style="border-top:0;">
              <form id="sort_form" action="" method="get">
                <div class="view-mode" style="display: none">
                  <ul>
                    <li class="active"> <a href="shop_grid.html"> <i class="fa fa-th-large"></i> </a> </li>
                    <li> <a href="shop_list.html"> <i class="fa fa-th-list"></i> </a> </li>
                  </ul>
                </div>
                <div class="sorter">
                  <div class="short-by">
                    <select id="sortProduct" style="width:100%;border: 1px solid #b22827;color: #b22827;" name="price_sort">
                      <option value="">{{__('product.sort')}}</option>
                      <option value="asc">{{__('Product.Low Price')}}</option>
                      <option value="desc">{{__('Product.High Price')}}</option>
                    </select>
                  </div>
                  
                  <div class="short-by page" style="margin-right:5px; display: none">
                    <select id="showProduct" style="width:100%;border: 1px solid #b22827;color: #b22827;" name="showProduct">
                      <option value="">Select Show</option>
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="15">15</option>
                      <option value="20">20</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div class="product-grid-area">
              <ul class="products-grid">
                @if(count($products) > 0)
                @foreach($products as $product)
                <li class="item col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                  @include('website.components.products-card', [
                                  'product' => $product
                              ])
                  
                  
                </li>
                @endforeach
                @else
                <p class="text-center">{{__('Product.No Products Found')}}</p>
                @endif
              </ul>
            </div>

            
            <div class="pagination-area filter-none" style="display: none">
            @if (!isset($_GET['show']))
            {!!$products->appends(request()->input())->render()!!}
            @endif
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </div>

@include('website.components.footer')





@endsection

@section('javascript')
<script>

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}



  jQuery(document).ready(function(){
    var sortQueryString = getUrlVars()["sort"];
    var showQueryString = getUrlVars()["show"];
    var sortProductOptions = [];
    var filtersArray = [];

    $('#sortProduct option').each(function(){
      sortProductOptions.push($(this).val());
    });
    

     jQuery('#sortProduct').change(function(e){
      
          var selectSort = $(this).val();
          if (selectSort != '') {
              location.href = '?sort='+selectSort;
          }
        
        });
     
     jQuery('#showProduct').change(function(e){
      
          var selectShow = $(this).val();
          if (selectShow != '') {
            if (sortProductOptions.includes(sortQueryString)) {
              location.href = '?sort='+sortQueryString+'&show='+selectShow;
            }else{
              location.href = window.location+'?show='+selectShow;
            }
          }
        
        });
      
      
    
     });
</script>
@endsection