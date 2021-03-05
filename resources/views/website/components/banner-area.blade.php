
@php($count = 1)
@if($homeCircleCategories != null)
@php($homeCircleCategories = (array)$homeCircleCategories)


<section class="banner-area">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

          <div class="row">
              @php ($dbCat = \App\Category::find($homeCircleCategories[1]->category))
              @if(isset($dbCat))
              <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6">
                <div class="banner-block"> <a href="{{ $dbCat->url }}"> <img src="{{ url('image/module/'.$homeCircleCategories[1]->image) }}"  alt="banner sunglasses"> </a>
                  <div class="text-des-container">
                    <div class="text-des" style='background: rgba(0, 0, 0, 0) url("{{ asset('website/images/bg_text_des.png') }}") repeat scroll 0 0;'>
                      <h2 style="font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif; ">{{ $dbCat->name }}</h2>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              @php($count++)


              @php($dbCat = \App\Category::find($homeCircleCategories[$count]->category))
              @if(isset($dbCat))

              <div class="col-xs-12 col-sm-6 col-lg-6 col-md-6">
                <div class="banner-block"> <a href="{{ $dbCat->url }}"> <img src="{{ url('image/module/'.$homeCircleCategories[$count]->image) }}"  alt="banner kids"> </a>
                  <div class="text-des-container">
                    <div class="text-des" style='background: rgba(0, 0, 0, 0) url("{{ asset('website/images/bg_text_des.png') }}") repeat scroll 0 0;'>
                      <h2 style="font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif; ">{{ $dbCat->name }}</h2>
                    </div>
                  </div>
                </div>
              @endif
              @php($count++)



            </div>
          </div>

        </div>

        @php($dbCat = \App\Category::find($homeCircleCategories[$count]->category))
        @if(isset($dbCat))
        <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
          <div class="banner-block"> <a href="{{ $dbCat->url }}"> <img src="{{ asset('website/images/cat1.png') }}" alt="banner arrival"> </a>
            <div class="text-des-container">
              <div class="text-des" style='background: rgba(0, 0, 0, 0) url("{{ asset('website/images/bg_text_des.png') }}") repeat scroll 0 0;'>
                <h2 style="font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif; ">{{ $dbCat->name }}</h2>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </section>

  @endif
