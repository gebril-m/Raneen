@if($content)
    <!--rounded category start-->
    <section class="rounded-category">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="slide-6 no-arrow">
                        @foreach($content->categories as $cat)
                            @php
                            $dbCat = \App\Category::find($cat->category);
                            @endphp
                        <div>
                            @if(isset($dbCat))
                            <div class="category-contain">
                                <a href="{{ $dbCat->url }}">
                                    <div class="img-wrapper">
                                        <img src="{{ image('module', $cat->image) }}" alt="category" class="img-fluid circle-cat">
                                    </div>
                                    <div>
                                        <div class="btn-rounded">
                                            {{ $dbCat->name }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--rounded category end-->
@endif
