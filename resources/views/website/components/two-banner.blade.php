
@if($homeTwoCards)
<div class="banner-section">
  <div class="container">
    <div class="row">

      @foreach(['left', 'right'] as $side)
      @php
          $obj = null;
          $type = null;
          $image = null;
          if($homeTwoCards->{'type_' . $side} == 'product') {
              $type = 'product';
              if($homeTwoCards->{'image_' . $side} != ''){
                $image = $homeTwoCards->{'image_' . $side};
              }
              $obj = \App\Product::where('id', $homeTwoCards->{'product_' . $side})
                  ->where('is_active', true)
                  ->where('stock', '>', 0)
                  ->first();
          } else if($homeTwoCards->{'type_' . $side} == 'category') {
              if($homeTwoCards->{'image_' . $side} != ''){
                $image = $homeTwoCards->{'image_' . $side};
              }
              $type = 'category';
              $obj = \App\Category::where('id', $homeTwoCards->{'category_' . $side})->first();
          }
      @endphp

      <div class="col-sm-6">
        @if(isset($obj))
        <figure><a title="@if(isset($obj->name)) {{ $obj->name }} @endif" href="@if(isset($obj->url)) {{ $obj->url }} @endif" target="_self" class="image-wrapper">
          @if(isset($image) && $image != '')
          <img src="{{image('module',$image)}}" style="width: 555px;height: 180px;" alt="banner laptop">
          @else
          <img src="@if($type == 'product') {{ $obj->thumbnail_url }} @else {{image('category',$obj->banner)}} @endif" style="width: 555px;height: 180px;" alt="banner laptop">
          @endif
        </a></figure>
        @else
        <figure> <a href="#" target="_self" class="image-wrapper"><img src="{{ asset('website/images/banner-laptop.jpg') }}" alt="banner laptop"></a></figure>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif


