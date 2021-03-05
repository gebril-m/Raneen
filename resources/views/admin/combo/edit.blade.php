@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Combo</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Combo</a></li>
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

                {!! Form::open([
                            "enctype" => "multipart/form-data",
                            'url' => route('admin.combo.update', $product->id), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_category_form']) !!}
                {{ method_field('PATCH') }}
                <div class="card">
                    <div class="card-body wizard-content">

                        <section>

                            
                                <div class="form-group">
                                    <label for="">Name Arabic  :</label>
                                    <input type="text" name="name_ar" value="{{$product->name_ar}}" class="form-control required" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Name English :</label>
                                    <input type="text"  name="name_en" value="{{$product->name_en}}" class="form-control required" required>
                                </div>

                                <div class="form-group" id="combo-values">
                                    @foreach($product->values as $value)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label >Quantity  :</label>
                                            <input type="number" name="num[]" value="{{$value->num}}" class="form-control required" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label >Percentage  :</label>
                                            <input type="number" name="percentage[]" value="{{$value->percentage}}" class="form-control required" required>
                                        </div>
                                        <div class="col-md-1">
                                            <label >Free Piece  :</label><br>
                                            <input type="checkbox" name="one_piece_free[]" {{ $value->one_piece_free ?'checked':'' }} style="margin-top: 19px;width: 17px;height: 17px;">
                                        </div>
                                        <div class="col-md-1">
                                            <label >Free Shipping  :</label><br>
                                            <input type="checkbox" name="shipping_free[]" {{ $value->shipping_free ?'checked':'' }} style="width: 17px;height: 17px;">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" class="btn btn-danger" style="margin-top: 29px;"  onclick="remove_combo_value(this);">-</a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <a href="#" class="btn btn-success"  onclick="add_combo_value();">+</a>
                                <br><br>

                                                        <!-- Start Add Products to Combo -->
                                <div class="products">
                                    <label>Products</label>
                                    <table class="table">
                                        <tr>
                                            <th width="33%">Product</th>
                                            <!-- <th>Discount</th> -->
                                            <th>Price</th>
                                            <th>Options</th>
                                        </tr>
                                        <tbody id="products">
                                        <!-- <tr class="no-products">
                                            <td colspan="4" class="text-center">THERE IS NO PRODUCTS TRY TO ADD ONE</td>
                                        </tr> -->
                                            @if(count($product->products) > 0)
                                            @foreach($product->products as $product)
                                                <tr>
                                                    <td><select class="form-control product" name="products[]" required>
                                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                                        </select></td>
                                                    <td><input type="text" class="form-control disabled price-field" name="price[]" value="@if($product->before_price != 0) {{$product->before_price}} @else {{$product->price}} @endif" disabled=""></td>
                                                    
                                                    <td>
                                                        <a href="#" class="btn btn-danger remote-product">[DELETE]</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        
                                        </tbody>
                                    </table>

                                    <a href="#" class="add-new-product btn btn-success">ADD NEW PRODUCT</a>
                                    <br><br>
                                </div>

                                <script type="text/html" id="product-row">
                                <tr>
                                        <td><select class="form-control product" name="products[]" required></select></td>
                                        <!-- <td><input type="number" name="discount[]" min="0" class="form-control discount" required /></td> -->
                                        <td><input type="text" class="form-control disabled price-field" name="price[]" disabled=""></td>
                                        <td>
                                            <a href="#" class="btn btn-danger remote-product">[DELETE]</a>
                                        </td>
                                    </tr>
                                </script>
                                <!-- End Add Products to Combo -->

                                <!-- Start Add Products to Combo -->
                                <div class="categories">
                                    <label>Categories</label>
                                    <table class="table">
                                        <tr>
                                            <th width="33%">Category</th>
                                            <!-- <th>Discount</th> -->
                                            
                                            <th>Options</th>
                                        </tr>
                                        <tbody id="categories">
                                        <!-- <tr class="no-categories">
                                            <td colspan="4" class="text-center">THERE IS NO CATEGORIES TRY TO ADD ONE</td>
                                        </tr> -->
                                        @if(count($product->categories) > 0)
                                        @foreach($categories as $category)
                                            <tr>
                                                <td><select class="form-control category" name="categories[]" required>
                                                        <option value="{{ $category->id }}" selected="selected">{{ $category->name }}</option>
                                                    </select></td>                                                
                                                <td>
                                                    <a href="#" class="btn btn-danger remote-category">[DELETE]</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>

                                    <a href="#" class="add-new-category btn btn-success">ADD NEW CATEGORY</a>
                                    <br><br>
                                </div>

                                <script type="text/html" id="category-row">
                                <tr>
                                        <td><select class="form-control category" name="categories[]" required></select></td>
                                        
                                        <td>
                                            <a href="#" class="btn btn-danger remote-category">[DELETE]</a>
                                        </td>
                                    </tr>
                                </script>
                                <!-- End Add Products to Combo -->
                                

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="checkbox0" name="active" value="on" @if($product->status=='active') checked @endif >
                                        <label class="custom-control-label" for="checkbox0">Combo Active</label>
                                    </div>
                                </label>
                            </div>


                            <br>
                            <hr>

                            <div class="row justify-content-center">
                                <button type="submit" class="btn btn-success">SAVE</button>
                            </div>

                        </section>



                    </div>

                </div>

                {!! Form::close() !!}

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
@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin-asset/dist/js/jquery.czMore.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>


    <script>

        var products = {};

        function select2() {
            $('.product').select2({
                // multiple: true,
                ajax: {
                    url: '{{ route('admin.combo.products') }}',
                    dataType: 'json',

                    processResults: function (data) {
                        data.results.map(item => {
                            products[item.id] = item;
                        })
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return data;
                    }

                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
            });

            $('.product').on('select2:select', function (e) {
                var data = e.params.data;

                calculate()

                // $('#before_price').val($('.product').select2('data').reduce(function (current, item) {
                //     return item.price + current;
                // }, 0))
            });
        }

        $(document).on('click', '.remote-product', function () {
            $(this).parent().parent().remove();

            if ($('#products').find('tr').length == 1) {
                $('.no-products').show();
            }

            calculate();

            return false;
        });

        $(document).on('keyup change', '.quantity, .discount', function () {
            calculate();
        });

        function calculate() {
            let total = 0;
            let dtotal = 0;
            let first_product = 0;
            $('.product').each(function (i) {
                // if ($(this).select2('data') && $(this).select2('data')[0] && $(this).select2('data')[0].price) {
                    if(Number(products[$(this).val()].before_price) != 0){
                        $(this).parents('tr').find('.price-field').val(products[$(this).val()].before_price);
                    }else{
                        $(this).parents('tr').find('.price-field').val(products[$(this).val()].price);
                    }
                if(i==0){
                    if(Number(products[$(this).val()].before_price) != 0){
                    first_product = products[$(this).val()].before_price;
                    }else{
                    first_product = products[$(this).val()].price;
                    }
                }
                total += products[$(this).val()].price * $('.quantity').eq(i).val();
                dtotal += products[$(this).val()].price * $('.quantity').eq(i).val() - $('.discount').eq(i).val();
                // }
            })

            $('#price').val(first_product);
            // $('#price').val(dtotal);
        }

        $('.add-new-product').click(function () {

            $('.no-products').hide();

            $('#products').append($('#product-row').html());

            select2();

            return false;
        });

        function add_combo_value()
        {
            let data='<div class="row"><div class="col-md-4"><label >Quantity  :</label><input type="number" name="num[]" class="form-control required" required></div><div class="col-md-4"><label >Percentage  :</label><input type="number" name="percentage[]" class="form-control required" required></div><div class="col-md-1"><label >Free Piece  :</label><br><input type="checkbox" name="one_piece_free[]" style="margin-top: 8px;width: 17px;height: 17px"></div><div class="col-md-1"><label >Free Shipping  :</label><br><input type="checkbox" name="shipping_free[]" style="margin-top: 8px;width: 17px;height: 17px;"></div><div class="col-md-2"><a href="#" class="btn btn-danger" style="margin-top: 29px;"  onclick="remove_combo_value(this);">-</a></div></div>';
            $("#combo-values").append(data);
        }

        function remove_combo_value(ele)
        {
            let element=ele;
            element.closest('.row').remove(); 
        }

        // categories
        function select3() {
            $('.category').select2({
                // multiple: true,
                ajax: {
                    url: '{{ route('admin.combo.categories') }}',
                    dataType: 'json',

                    processResults: function (data) {
                        data.results.map(item => {
                            products[item.id] = item;
                        })
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return data;
                    }

                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
            });

            $('.category').on('select3:select', function (e) {
                var data = e.params.data;
            });
        }

        $('.add-new-category').click(function () {

            $('.no-categories').hide();

            $('#categories').append($('#category-row').html());

            select3();

            return false;
        });

        $(document).on('click', '.remote-category', function () {
            $(this).parent().parent().remove();

            if ($('#categories').find('tr').length == 1) {
                $('.no-categories').show();
            }

            

            return false;
        });

    </script>


@endsection
