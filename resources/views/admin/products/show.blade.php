@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Pages</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Categories</a></li>
                        <li class="breadcrumb-item active">{{ $row->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    @foreach($languages as $locale)
                           <h5 class="text-info">{{$locale->name}} content</h5>
                            <section>
                                <div class="form-group">
                                    <label for="name[{{$locale->locale}}]">Name {{$locale->name}} :</label>
                                     {{ $row->translate($locale->locale)->name ?? '' }}<p></p>
                                     <label for="slug[{{$locale->locale}}]">Slug {{$locale->name}} :</label>
                                     {{ $row->translate($locale->locale)->slug ?? '' }}<p></p>
                                     <label for="description[{{$locale->locale}}]">Description {{$locale->name}} :</label>
                                     {!! $row->translate($locale->locale)->description ?? '' !!} 
                                </div>
                                <h6>Stock</h6>
                                </section>
                        <section>
                        @endforeach

                            <h5 class="text-info">Stock Details</h5>

                            <div class="form-group">
                                <label for="stock">Stock</label>
                                {{ $row->stock ?? '' }}<p></p>
                                <label for="minimum_stock">Low Stock Notification</label>
                                {{ $row->minimum_stock ?? '' }}<p></p>
                                <label for="price">Price</label>
                                {{ $row->price }}<p></p>
                                <label for="reward_points">Reward Points</label>
                                {{ $row->reward_points ?? '' }}<p></p>
                                <label for="reward_points">Allow Item Return</label>
                                @if($row->return_allowed) Yes @else No @endif<p></p>
                                <label for="reward_points">Return duration</label>
                                {{$row->return_duration}}<p></p>
                                <label for="reward_points">On sale?</label>
                                @if($row->on_sale) Yes @else No @endif<p></p>
                                <label for="reward_points">Before Price (Before Discount)</label>
                                {{ $row->before_price }}<p></p>
                                <label for="is_hot">Is hot product?</label>
                                @if($row->is_hot) Yes @else No @endif<p></p>
                                <label for="is_hot">Is Combo product?</label>
                                @if($row->is_combo) Yes @else No @endif<p></p>
                                <label for="hot_starts_at">Hot starts at</label>
                                {{ $row->hot_starts_at }}<p></p>
                                <label for="hot_ends_at">Hot ends at</label>
                                {{ $row->hot_ends_at }}<p></p>
                                <label for="hot_price">New Price</label>
                                {{ $row->hot_price }}<p></p>
                                <label for="hot_price">Combo</label>
                                 
                            </div>
     
                            </section>
                            
                        <section>

                            <h5 class="text-info">Image list</h5>
                            <div class="gallery">
                                <ul>
                                    @foreach($row->images as $image)
                                        <li @if($image->image == $row->thumbnail) class="selected" @endif >
                                            <img class="thumbnail" src="{{ thumb('product', 150, 150, $image->image) }}" alt="">
                                            <input type="hidden" name="images~[]" value="{{ $image->id }}">
                                            <input type="hidden" name="thumbnail[]" class="thumb-input" value="{{ $image->image == $row->thumbnail ? 1 : 0 }}" />
                                            <div class="options">
                                                @if($image->image == $row->thumbnail)
                                                    <a href="#" class="set-thumbnail"><i class="mdi mdi-check-circle-outline"></i> Thumbnail</a>
                                                @else
                                                    <a href="#" class="set-thumbnail"><i class="mdi mdi-checkbox-blank-circle-outline"></i> Thumbnail</a>
                                                @endif
                                                <a href="#" class="delete-gallery"><i class="delete mdi mdi-delete"></i></a>
                                            </div>
                                            <i class="icon mdi mdi-check-circle-outline"></i>
                                        </li>
                                    @endforeach
                                     
                                </ul>
                            </div>
                            </section>
                            <h6>Meta Content</h6>
                        <section>

                            <h5 class="text-info">Main Info</h5>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                 {{ ($row->categories[0]->id ?? 0) }} <p></p>
                                <label for="brand_id">Brand</label>
                                {{ $row->brand_id }} <p></p>
                                <label for="manufacturer_id">Manufacturer</label>
                                 {{ $row->manufacturer_id }}  <p></p>
                                <label for="barcode">Barcode</label>
                                {{ $row->barcode }} <p></p>
                             
                                <label for="item_id">Item ID</label>
                                 {{ $row->item_id }}<p></p>
                             
                                <label for="axapta_code">Axapta Code</label>
                                 {{ $row->axapta_code }}<p></p>
                             
                                <label for="weight">Weight</label>
                                {{ $row->weight }}<p></p>
                             
                                <label for="length">Length</label>
                                 {{ $row->length }}<p></p>
                             
                                <label for="width">Width</label>
                                 {{ $row->width }}<p></p>
                             
                                <label for="height">Height</label>
                                 {{ $row->height }}<p></p>
                              

                            @foreach($languages as $locale)
                                <h6 class="text-info">{{$locale->name}} SEO</h6>
                                <section>
                                    <div class="form-group">
                                        <label for="meta_title[{{$locale->locale}}">Meta Title {{$locale->name}}:</label>
                                         {{ $row->translate($locale->locale)->meta_title ?? '' }} <p></p>
                                     
                                        <label for="meta_keywords[{{$locale->locale}}]">Meta Keywords {{$locale->name}} :</label>
                                         {{ $row->translate($locale->locale)->meta_keywords ?? '' }}<p></p>
                                     
                                        <label for="meta_description[{{$locale->locale}}]">Meta Description {{$locale->name}} :</label>
                                         {!! $row->translate($locale->locale)->meta_description ?? '' !!}<p></p>
                                    </div>
                                </section>
                            @endforeach

                        </section>

                        <h6>Attributes</h6>
                        <section>

                            <h6 class="text-info">Attributes</h6>
                             
 <!-- this product attributes -->
                                @foreach($row->attributes as $attr)
                                 
                                 @if($attr->group_id != "")
                                     <div class="recordset">
                                         <div class="row">
                                             <div class="col-2">
                                                 {{$attr->pivot->attribute_id}}
                                             </div>
                                             <div class="col-2">
                                                 {{$attr->pivot->quantity}} 
                                             </div>
                                             <div class="col-2">
                                                  
                                                 
                                                 @php
                                                     $product_attribute_image=json_decode($attr->pivot->picture);
                                                      
                                                     $destinationPath = public_path('upload/products/');
                                                 @endphp
                                                 <div style="display:-webkit-flex;">
                                                 @foreach($product_attribute_image as $img)
                                                     <img src="{{ URL::to('/upload/products/') }}/{{$img}}" style="width:150px; height:50px;">
                                                 @endforeach
                                                 </div>
                                                 
                                             </div>
                                             <div class="col-2">
                                                   {{$attr->pivot->price}} 
                                             </div>
                                             <div class="col-2">
                                                   {{$attr->pivot->code}} 
                                             </div>
                                              
                                         </div>
                                     </div>
                                 @endif
                             @endforeach
                            
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
@endsection
@section('style')
    <link href="{{asset('admin-asset/assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
    <!--alerts CSS -->
    <link href="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-asset/dist/css/custom.css')}}" rel="stylesheet">

    <!-- Theme included stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
@endsection
