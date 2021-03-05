
@if($homeCategories!=null)

@php
$dbCats = [];
foreach ($homeCategories as $item) {
    $dbCat = \App\Category::find($item->category);
    if(!$dbCat) continue;
    $dbCats[$item->category] = $dbCat;
}
@endphp

<div class="container">
    <div class="home-tab">
      <div class="tab-title text-left">
        <h2>@lang('home.best selling')</h2>
        <ul class="nav home-nav-tabs home-product-tabs">

          @php $i=0 @endphp
          @foreach($homeCategories as $item)
              @php
              $i++;
              if(!isset($dbCats[$item->category])) continue;
              $dbCat = $dbCats[$item->category];
              @endphp
              <li @if($i == 1) class="active" @endif><a href="#tab{{ $item->category }}" data-toggle="tab" aria-expanded="false">{{ $dbCat->name }}</a></li>
          @endforeach

        </ul>
      </div>
      <div id="productTabContent" class="tab-content">
        @php $i=0 @endphp
        @foreach($homeCategories as $item)
              @php
              $i++;
                  if(!isset($dbCats[$item->category])) continue;
                  $dbCat = $dbCats[$item->category];
              @endphp
              <div class="tab-pane @if($i == 1) active @endif in" id="tab{{ $item->category }}">

                  <div class="featured-pro">
                    <div class="slider-items-products">
                      <div id="computer-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col4">

                          @php
                              $products = $dbCat->products()->with(['promotions' => function($q){
                                  $q->orderBy('end', 'desc')->get()->first();
                              }])
                              ->where('is_active', true)
                              ->where('stock', '>', 0)
                              ->limit(10)->get();
                          @endphp

                          @foreach($products as $product)
                              @include('website.components.products-card', [
                                  'product' => $product
                              ])
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>

              </div>
          @endforeach


      </div>
    </div>
  </div>
  @endif
