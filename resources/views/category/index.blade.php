@extends('layouts.app')
@section('container')
    <div class="clearfix"></div>
    <!-- breadcrumb start -->
    <div class="breadcrumb-main margin-large">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-contain">
                        <div>
                            <h2>{{trans('home.All Categories')}}</h2>
                            <ul>
                                <li><a href="#"> <h2>{{trans('home.home')}}</h2></a></li>
                                <li><i class="fa fa-angle-double-right"></i></li>
                                <li><a href="#"> <h2>{{trans('home.All Categories')}}</h2></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->
    <section class="collection section-big-py-space ratio_square bg-light">
        <div class="container">
            <div class="row partition-collection">
                @foreach($allcategories as $category)
                <div class="col-lg-3 col-md-6">
                    <div class="collection-block">
                        <div><img @if($category->banner)) src="{{ image('category', $category->banner) }}" @else src="{{asset('/assets/images/collection/7.jpg')}}" @endif class="img-fluid  bg-img img-category" alt=""></div>
                        <div class="collection-contain">
                            @php $cat = \App\Product::whereHas('categories', function ($query) use ($category) {
                                    $query->where('categories.id', $category->id);
                                })->count() @endphp
                            <h4>({{$cat}} {{trans('products.products')}})</h4>
                            <h3>{{$category->name}}</h3>
                            <a href="{{url('/'.$category->slug.'/c')}}" class="btn btn-normal">{{trans('category.shop now')}}</a></div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </section>

@endsection
