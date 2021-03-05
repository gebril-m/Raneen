@if($bigSale[0] != null)

<div class="inner-box">
    <div class="container">
      <div class="row">
        <!-- Banner -->
        <div class="col-md-3 top-banner hidden-sm">
          <div class="jtv-banner3">
            <div class="jtv-banner3-inner"><a href="@if (\Lang::getLocale() == 'en') {{ $bigSale[0]->link_en }} @endif @if (\Lang::getLocale() == 'ar') {{ $bigSale[0]->link_ar }} @endif "><img src="{{ image('module', $bigSale[0]->image) }}" alt="{{ $bigSale[0]->wordb_en }}"></a>
              <div class="hover_content">
                <div class="hover_data">
                  @if (\Lang::getLocale() == 'en')
                    <div class="title"> {{ $bigSale[0]->wordb_en }} </div>
                    <div class="desc-text">{{ $bigSale[0]->worda_en }}</div>
                  @endif

                  @if (\Lang::getLocale() == 'ar')
                    <div class="title"> {{ $bigSale[0]->wordb_ar }} </div>
                    <div class="desc-text">{{ $bigSale[0]->worda_ar }}</div>
                    {{-- {{ dd($bigSale[0]) }} --}}

                  @endif

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Best Sale -->
        <div class="col-sm-12 col-md-9 jtv-best-sale special-pro">
          <div class="jtv-best-sale-list">
            <div class="wpb_wrapper">
              <div class="best-title text-left">
                <h2>{{trans('home.Special Products')}}</h2>
              </div>
            </div>
            <div class="slider-items-products">
              <div id="jtv-best-sale-slider" class="product-flexslider">
                <div class="slider-items">

                  @foreach($bigSale[1]->products as $pId)

                  @php
                  $product = \App\Product::whereIsActive(1)->find($pId);
                  @endphp

                  @include('website.components.products-card', [
                    'product' => $product
                  ])



                  @endforeach

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @endif
