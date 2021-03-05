@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Products</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Products</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('has_not_periorty'))
            <div class="alert alert-danger">
                <ul>
                    <li>{{session('has_not_periorty')}}</li>
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body wizard-content">

                        {!! Form::open([
                            "enctype" => "multipart/form-data",
                            'url' => route('admin.products.update', $row->id), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_category_form']) !!}
                        {{ method_field('PATCH') }}
                        @foreach($languages as $locale)
                            <h6>{{$locale->name}} content</h6>
                            <section>
                                <div class="form-group">
                                    <label for="name[{{$locale->locale}}]">Name {{$locale->name}} :</label>
                                    <input type="text" name="name[{{$locale->locale}}]" value="{{ $row->translate($locale->locale)->name ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="slug[{{$locale->locale}}]">Slug {{$locale->name}} :</label>
                                    <input type="text" name="slug[{{$locale->locale}}]" value="{{ $row->translate($locale->locale)->slug ?? '' }}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="description[{{$locale->locale}}]">Description {{$locale->name}} :</label>
                                    <textarea id="description[{{$locale->locale}}]" name="description[{{$locale->locale}}]" class="form-control summernote" cols="30" rows="10">{{ $row->translate($locale->locale)->description ?? '' }}</textarea>
                                </div>
                            </section>
                        @endforeach

                        <h6>Stock</h6>
                        <section>

                            <h6 class="text-info">Stock Details</h6>

                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input min="0" type="number" step="1" class="form-control required" id="stock" name="stock" required value="{{ $row->stock ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label for="minimum_stock">Low Stock Notification</label>
                                <input min="0" type="number" step="1" class="form-control required" id="minimum_stock" name="minimum_stock" required value="{{ $row->minimum_stock ?? '' }}">
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input  min="0" type="number" class="form-control required" id="price" name="price" required value="{{ $row->before_price != 0? $row->before_price:$row->price }}">
                            </div>

                            <div class="form-group">
                                <label for="reward_points">Reward Points</label>
                                <input type="number" class="form-control required" id="price" min="0" value="{{ $row->reward_points ?? '' }}" name="reward_points">
                            </div>

                            <div class="form-group">
                                <label for="return_allowed">
                                    <input type="checkbox" id="return_allowed" name="return_allowed"
                                    @if($row->return_allowed) checked @endif
                                    >
                                    Allow Item Return
                                </label>
                            </div>

                            <div class="form-group" data-show="return_allowed" style="display: none">
                                <label for="return_duration">Return duration</label>
                                <input min="0" type="number" step="1" class="form-control" id="return_duration" name="return_duration" value="{{ $row->return_duration }}">
                            </div>

                            <div class="form-group">
                                <label for="on_sale">

                                    <input type="checkbox" id="on_sale" name="on_sale" @if($row->on_sale) checked @endif >
                                    On sale?
                                </label>
                            </div>

                            <div class="form-group" data-show="on_sale" style="display: none">
                                <label for="before_price">Price After Discount</label>

                                <input min="0" type="number" class="form-control" id="before_price" name="before_price" value="{{ $row->price }}">
                            </div>

                            <div class="form-group" data-show="on_sale" style="display: none">
                                <label for="sale_ends_at">On Sale ends at</label>
                                <input type="text" class="form-control" id="sale_ends_at" name="sale_ends_at" value="{{ old('sale_ends_at') }}">
                            </div>

                            <div class="form-group">
                                <label for="is_hot">
                                    <input type="checkbox" id="is_hot" name="is_hot" @if($row->is_hot) checked @endif >
                                    Is hot product?
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="is_combo">
                                    <input type="checkbox" id="is_combo" name="is_combo">
                                    Is Combo product?
                                </label>
                            </div>

                            <div class="form-group" data-show="is_hot" style="display: none">
                                <label for="hot_starts_at">Hot starts at</label>
                                <input type="text" class="form-control" id="hot_starts_at" name="hot_starts_at" value="{{ $row->hot_starts_at }}">
                            </div>

                            <div class="form-group" data-show="is_hot" style="display: none">
                                <label for="hot_ends_at">Hot ends at</label>
                                <input type="text" class="form-control" id="hot_ends_at" name="hot_ends_at" value="{{ $row->hot_ends_at }}">
                            </div>

                            <div class="form-group" data-show="is_hot" style="display: none">
                                <label for="hot_price">New Price</label>
                                <input min="0" type="number" class="form-control" id="hot_price" name="hot_price" value="{{ $row->hot_price }}">
                            </div>

                            <div class="form-group" data-show="is_combo" style="display: none">
                                <label class="mdb-main-label">Combo</label>
                                <select class="form-control" multiple="multiple" searchable="Search here.." id="combos" name="combo_id[]" style="width: 100%;" >
                                  <!-- <option value="" disabled selected>select combo</option> -->

                                  @foreach($combos as $combo)
                                  <option value="{{$combo->id}}" {{in_array( $combo->id , $row->getComboIdsAttribute())? 'selected' : ''}}>{{ app()->getLocale()=='ar'? $combo->name_ar: $combo->name_en}}</option>
                                  @endforeach

                                </select>

                            </div>

                        </section>

                        <h6>Images</h6>
                        <section>

                            <h6 class="text-info">Image list</h6>

                            <style>
                                .gallery ul {
                                    padding: 0;
                                    margin: 0;
                                }
                                .gallery ul {
                                    list-style: none;
                                }
                                .gallery ul li {
                                    margin: 5px;
                                    float: left;
                                    padding: 3px;
                                    border: 1px solid #DDD;
                                    width: 200px;
                                    height: 200px;
                                    position: relative;
                                    overflow: hidden;
                                }
                                .gallery ul li img {
                                    width: 192px;
                                    max-height: 192px;
                                }
                                .gallery ul li .options {
                                    position: absolute;
                                    height: 30px;
                                    left: 3px;
                                    bottom: 3px;
                                    right: 3px;
                                    padding: 0 10px;
                                    background: rgba(0, 0, 0, 0.5);
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                }
                                .gallery ul li .options a {
                                    color: white;
                                    font-size: 14px;
                                }
                                .gallery ul li .options i {
                                    font-size: 20px;
                                }
                                .gallery ul li .options i.delete {
                                    color: red;
                                }
                                .gallery .icon {
                                    display: none;
                                }
                                .gallery .selected .icon {
                                    display: block;
                                    position: absolute;
                                    font-size: 50px;
                                    color: green;
                                    left: 50%;
                                    top: 50%;
                                    transform: translateY(-50%) translateX(-50%);
                                }
                                .add-new {
                                    cursor: pointer;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                }
                                .add-new i {
                                    font-size: 30px;
                                }
                            </style>

                            <script id="gallery-item" type="text/html">
                                <li>
                                    <img class="thumbnail" src="" alt="">
                                    <input type="file" name="images[]" class="file" />
                                    <input type="hidden" name="thumbnail[]" class="thumb-input" value="0" />
                                    <div class="options">
                                        <a href="#" class="set-thumbnail"><i class="mdi mdi-checkbox-blank-circle-outline"></i> Thumbnail</a>
                                        <a href="#" class="delete-gallery"><i class="delete mdi mdi-delete"></i></a>
                                    </div>
                                    <i class="icon mdi mdi-check-circle-outline"></i>
                                </li>
                            </script>

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
                                    <li class="add-new">
                                        <a href="#"><i class="mdi mdi-plus-box-outline"></i></a>
                                    </li>
                                </ul>
                            </div>

                        </section>

                        <h6>Meta Content</h6>
                        <section>

                            <h6 class="text-info">Main Info</h6>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control" onchange="attributesDependOnCategory(this)">
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}" @if($id == ($row->categories[0]->id ?? 0)) selected @endif >{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" @if($brand->id == $row->brand_id) selected @endif>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="manufacturer_id">Manufacturer</label>
                                <select name="manufacturer_id" id="manufacturer_id" class="form-control">
                                    @foreach($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}" @if($manufacturer->id == $row->manufacturer_id) selected @endif>{{ $manufacturer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text" class="form-control" id="barcode" name="barcode" value="{{ $row->barcode }}">
                            </div>

                            <div class="form-group">
                                <label for="item_id">Item ID</label>
                                <input type="text" class="form-control" id="item_id" name="item_id" value="{{ $row->item_id }}">
                            </div>
                            <div class="form-group">
                                <label for="axapta_code">Axapta Code</label>
                                <input type="text" class="form-control" id="axapta_code" name="axapta_code" value="{{ $row->axapta_code }}">
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight</label>
                                <input type="number" class="form-control" id="weight" name="weight" value="{{ $row->weight }}">
                            </div>
                            <div class="form-group">
                                <label for="length">Length</label>
                                <input type="number" class="form-control" id="length" name="length" value="{{ $row->length }}">
                            </div>
                            <div class="form-group">
                                <label for="width">Width</label>
                                <input type="number" class="form-control" id="width" name="width" value="{{ $row->width }}">
                            </div>
                            <div class="form-group">
                                <label for="height">Height</label>
                                <input type="number" class="form-control" id="height" name="height" value="{{ $row->height }}">
                            </div>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" @if($row->is_active) checked @endif id="checkbox0" name="active">
                                        <label class="custom-control-label" for="checkbox0">Product Active</label>
                                    </div>
                                </label>
                            </div>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" @if($row->is_point) checked @endif  id="checkbox0" name="point">
                                        <label class="custom-control-label" for="checkbox0">Point</label>
                                    </div>
                                </label>
                            </div>

                            <hr>

                            @foreach($languages as $locale)
                                <h6 class="text-info">{{$locale->name}} SEO</h6>
                                <section>
                                    <div class="form-group">
                                        <label for="meta_title[{{$locale->locale}}">Meta Title {{$locale->name}}:</label>
                                        <input type="text" name="meta_title[{{$locale->locale}}]" value="{{ $row->translate($locale->locale)->meta_title ?? '' }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords[{{$locale->locale}}]">Meta Keywords {{$locale->name}} :</label>
                                        <input type="text" name="meta_keywords[{{$locale->locale}}]" value="{{ $row->translate($locale->locale)->meta_keywords ?? '' }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description[{{$locale->locale}}]">Meta Description {{$locale->name}} :</label>
                                        <textarea name="meta_description[{{$locale->locale}}]" rows="4" class="form-control">{{ $row->translate($locale->locale)->meta_description ?? '' }}</textarea>
                                    </div>
                                </section>
                            @endforeach

                        </section>

                        <h6>Attributes</h6>
                        <section>

                            <h6 class="text-info">Attributes</h6>
                            <input type="hidden" id="attributes_total" value="{{count($row->attributes)}}" >
 <!-- this product attributes -->
 @if(count($row->attributes) > 0)
 @foreach($row->attributes as $attr)

                                 @if($attr->group_id != "")
                                     <div class="recordset">
                                         <div class="row">
                                             <div class="col-2">
                                                 @foreach($attributes as $attribute)
                                                         @if($attribute->id==$attr->pivot->attribute_id)

                                                         <select name="product_attributes[{{ $loop->iteration }}][]" class="form-control product_attributes" id="attributes2">
                                                             <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                         </select>
                                                         @endif

                                                     @endforeach
                                             </div>
                                             <div class="col-2">
                                                 <input type="text" name="attribute_values[{{ $loop->iteration }}][]" placeholder="quantity" class="form-control attribute_values" value="{{$attr->pivot->quantity}}">
                                             </div>
                                             <div class="col-2">
                                                 <input type="file" name="attribute_pictures[{{ $loop->iteration }}][]" class="form-control attribute_pictures">
                                                 @if($attr->pivot->picture != null)
                                                 @php
                                                     $product_attribute_image=json_decode($attr->pivot->picture);
                                                     $product__old_attribute_image=json_encode($attr->pivot->picture);
                                                     $destinationPath = public_path('upload/products/');
                                                 @endphp
                                                 <div style="display:-webkit-flex;">
                                                 @foreach($product_attribute_image as $img)
                                                     <img src="{{ URL::to('/upload/products/') }}/{{$img}}" style="width:150px; height:50px;">
                                                 @endforeach
                                                 </div>
                                                 <input type="hidden" name="attribute_old_pictures[{{ $loop->iteration }}][]" value="{{$product__old_attribute_image}}">
                                                 @endif
                                             </div>
                                             <div class="col-2">
                                                 <input type="text" name="attribute_prices[{{ $loop->iteration }}][]" placeholder="Price" class="form-control attribute_prices" value="{{$attr->pivot->price}}">
                                             </div>
                                             <div class="col-2">
                                                 <input type="text" name="attribute_codes[{{ $loop->iteration }}][]" placeholder="Code" class="form-control attribute_codes" value="{{$attr->pivot->code}}">
                                             </div>
                                             <div class="col-1">
                                                 <a href="#" class="add-new-category btn btn-danger" onclick="deleteAttribute(this)">DELETE</a>
                                             </div>
                                         </div>
                                     </div>
                                 @endif
                             @endforeach
                             @endif
                            <div id="attr-container">

                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <a href="#" class="add-new-category btn btn-success" onclick="addNewAtteibute()">ADD NEW ATTRIBUTE</a>

                                </div>
                                <div id="error"  role="alert">

                                </div>
                            </div>
                            <br><br>
                        </section>
                        <button type="submit" class="btn btn-primary" >Save Anyway</button>

                        {!! Form::close() !!}>

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
    <link href="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-asset/dist/css/custom.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin-asset/dist/js/jquery.czMore.js')}}"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script> -->
    <script src="{{asset('admin-asset/assets/select2.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <script>

        $(function() {
            $('#minimum_stock').change(function () {
                $('#minimum_stock').prop('max', $('#stock').val())
            })

            $('#before_price').change(function () {
                $('#before_price').prop('max', $('#price').val())

            })
            $('#hot_price').change(function(){
                $('#hot_price').prop('max', $('#price').val())
            })

            $('#combos').select2();

            jQuery('#hot_starts_at').datetimepicker({
                minDate: 'today',
            });
            jQuery('#hot_ends_at').datetimepicker({
                minDate: 'today',
            });
            jQuery('#sale_ends_at').datetimepicker({
                minDate: 'today',
            });

            $('#return_allowed').change(function () {
                if($(this).is(':checked')) {
                    $('[data-show="return_allowed"]').slideDown();
                } else {
                    $('[data-show="return_allowed"]').slideUp();
                }
            });

            $('#on_sale').change(function () {
                if($(this).is(':checked')) {
                    $('#is_hot').prop('checked', false).trigger('change');
                    $('[data-show="on_sale"]').slideDown();
                } else {
                    $('[data-show="on_sale"]').slideUp();
                }
            });


            $('#is_hot').change(function () {
                if($(this).is(':checked')) {
                    $('#on_sale').prop('checked', false).trigger('change');
                    $('[data-show="is_hot"]').slideDown();
                } else {
                    $('[data-show="is_hot"]').slideUp();
                }
            });

            $('#is_combo').change(function () {
                if($(this).is(':checked')) {
                    $('#on_sale').prop('checked', false).trigger('change');
                    $('#is_hot').prop('checked', false).trigger('change');
                    $('[data-show="is_combo"]').slideDown();
                } else {
                    $('[data-show="is_combo"]').slideUp();
                }
            });

            $('.summernote').summernote({
                height: 350, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });

            $('.inline-editor').summernote({
                airMode: true
            });

        });

        window.edit = function() {
            $(".click2edit").summernote()
        },

            window.save = function() {
                $(".click2edit").summernote('destroy');
            }

    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(input).parent().find('img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).on('change', '.file', function () {
            readURL(this);
        })
    </script>

    <script>
        $(document).on('click', '.set-thumbnail', function () {
            $('.gallery li').removeClass('selected');
            $('.gallery .thumb-input').val(0);
            $('.gallery .set-thumbnail').find('i').removeClass('mdi-check-circle-outline')
                .addClass('mdi-checkbox-blank-circle-outline')
            $(this).parent().parent().addClass('selected');
            $(this).find('i').removeClass('mdi-checkbox-blank-circle-outline')
                .addClass('mdi-check-circle-outline')
            $(this).parent().parent().find('.thumb-input').val(1);
            return false;
        });
        $(document).on('click', '.delete-gallery', function () {
            $(this).parent().parent().remove();
            return false;
        })
        $(document).on('click', '.add-new', function () {
            var html = $('#gallery-item').html();
            $('.gallery ul li:last').before(html)
            return false;
        })
    </script>

    <script type="text/javascript">

        //Custom design form example
        var form = $(".tab-wizard");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
        });

        //Custom design form example
        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",

            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: "Submit"
            },
            onFinished: function (event, currentIndex) {
                var quantity =0;
                var stock = $('#stock').val();
                var inputs = $(".attribute_values");

                for(var i = 0; i < inputs.length; i++){
                    quantity += parseFloat($(inputs[i]).val());
                }
                if(quantity > stock){
                    $('form').submit( function(ev) {
                        ev.preventDefault();
                    });
                    $("#error").addClass("alert alert-danger").text("The Quantity for Attributes Must Be Less Than The Whole Stock Which is "+stock);
                }
                else if(isNaN(quantity) === true){
                    $('form').submit( function(ev) {
                        ev.preventDefault();

                    });

                    $("#error").addClass("alert alert-danger").text("Quantity Must Be a Number");
                }
                else{
                    $('form').submit( function(ev) {
                        $(this).unbind('submit').submit()
                    });
                    $("#error").removeClass("alert alert-danger").text("");
                    $('#add_category_form').submit();
                }
            }
        });
    </script>
    <script>
    var attributes_total = parseInt(document.getElementById('attributes_total').value);
    var count=attributes_total + 1;
        function addNewAtteibute(cat_ids)
        {
            $('.btn-primary').remove();

            //$('#attr-container').append($('#first-attribute').html());

            var html = $("#attr-container").first().clone();
                html.find('.product_attributes').attr({ name: "product_attributes["+count+"][]"});
                html.find('.product_attributes').val('');
                html.find('.attribute_values').attr({ name: "attribute_values["+count+"][]"});
                html.find('.attribute_values').val('')
                html.find('.attribute_pictures').attr({ name: "attribute_pictures["+count+"][]"});
                html.find('.attribute_pictures').val('');
                html.find('.attribute_prices').attr({ name: "attribute_prices["+count+"][]"});
                html.find('.attribute_prices').val('');
                html.find('.attribute_codes').attr({ name: "attribute_codes["+count+"][]"});
                html.find('.attribute_codes').val('');
                $("#attr-container").last().after(html);
                //$('#attr-container').append($('#first-attribute').html());
            count++;

        }
        function deleteAttribute(ele)
        {
            let element=ele;
            element.closest('.recordset').remove();
        }
        function attributesDependOnCategory(ele)
        {
            cat_ids=$(ele).val();
            //console.log(cat_ids);
            $.ajax({
                url: '{{ url('big-boss/attributes-product') }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType :'html',
                data:{
                    'ids':cat_ids
                },
                success: function (data) {
                    console.log(data);
                    if ($('#first-attribute-container').length) {
                        $('#first-attribute-container').html(data);
                        currentAttributesDependOnCategory($('#category_id'));
                    }else{
                        $('#attr-container').append(data);
                    }
                }
            })
            //addNewAtteibute(cat_ids);
        }

        function currentAttributesDependOnCategory(ele)
        {
            cat_ids=$(ele).val();
            //console.log(cat_ids);
            $.ajax({
                url: '{{ url('big-boss/attributes-current-product') }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType :'html',
                data:{
                    'ids':cat_ids
                },
                success: function (data) {
                    console.log(data);
                    $('select[name="attributes[]"]').each(function(){
                        $(this).html(data);
                    })
                }
            })
            //addNewAtteibute(cat_ids);
        }
        category_id
        $(function() {

            attributesDependOnCategory($('#category_id'));

        })
    </script>

    <!-- Hot Price Checker -->
    <!-- <script>
        $('#hot_price').keyup(function(){
        if( $('#hot_price').val() > $('#price').val() ){
            $('#hot_price').val($('#price').val());
        }
    })
    $('#hot_price').change(function(){
        if( $('#hot_price').val() > $('#price').val() ){
            $('#hot_price').val($('#price').val());
        }
    })
    </script> -->
    <script>
        $("#czContainer").czMore({styleOverride:true});
    </script>
@endsection
