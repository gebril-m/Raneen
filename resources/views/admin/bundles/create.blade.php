@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Bundles</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Bundles</a></li>
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
        @if(session('message'))
            <div class="alert alert-danger">
                <ul>
                    @foreach(session('message') as $id)
                        <li>Quantity of the Product {{$id}} is bigger than its stock</li>
                    @endforeach
                </ul>
            </div>

        @endif

        @if(session('validation_conditions'))
            <div class="alert alert-danger">
                <ul>
                    @foreach(session('validation_conditions') as $validate)
                    <li>{{$validate}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12">

                {!! Form::open([
                            "enctype" => "multipart/form-data",
                            'url' => route('admin.bundles.store'), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_category_form']) !!}

                <div class="card">
                    <div class="card-body wizard-content">

                        <section>

                        @foreach($languages as $locale)
                            <div class="form-group">
                                <label for="name[{{$locale->locale}}]">Name {{$locale->name}} :</label>
                                <input type="text" name="name[{{$locale->locale}}]" class="form-control required" required>
                            </div>
                            <div class="form-group">
                                <label for="slug[{{$locale->locale}}]">Slug {{$locale->name}} :</label>
                                <input type="text" name="slug[{{$locale->locale}}]" class="form-control required" value="{{ old("slug." . $locale->locale) }}" required>

                                <div class="form-group">
                                    <label for="description[{{$locale->locale}}]">Description {{$locale->name}} :</label>
                                    <textarea id="description[{{$locale->locale}}]" name="description[{{$locale->locale}}]" class="form-control summernote" cols="30" rows="10">{{ old("description." . $locale->locale) }}</textarea>
                                </div>
                            </div>
                        @endforeach
                            <div class="form-group">
                                <label for="logo">Image:</label>
                                <input class="bundle_image" type="file" name="bundle_image" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <img class="image-preview"  style="display: none;width: 100px;height: 100px;">
                            </div>

                            <div class="form-group">

                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control categories" onchange="select2()">

                                    @foreach($categories as $id => $name)

                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- <div class="form-group">
                                <label for="brand_id">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="manufacturer_id">Manufacturer</label>
                                <select name="manufacturer_id" id="manufacturer_id" class="form-control">
                                    @foreach($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                    @endforeach
                                </select>
                            </div> -->

                            <div class="products">
                                <label>Products</label>
                                <table class="table">
                                    <tr>
                                        <th width="33%">Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Discount (Amount/Percentage)</th>
                                        <th>Price After</th>
                                        <th>Options</th>
                                    </tr>
                                    <tbody id="products">
                                    <tr class="no-products">
                                        <td colspan="4" class="text-center">THERE IS NO PRODUCTS TRY TO ADD ONE</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <a href="#" class="add-new-product btn btn-success">ADD NEW PRODUCT</a>
                                <br><br>
                            </div>

                            <script type="text/html" id="product-row">
                            <tr>
                                    <td><select class="form-control product" name="products[]" required></select></td>
                                    <td><input type="number" name="quantity[]" class="form-control quantity" value="1" min="1" required /></td>
                                    <td><input type="number" name="price[]" class="form-control price" required /></td>
                                    <td><input type="text" name="discount[]" min="0" class="form-control discount" required /></td>
                                    <td><input type="number" name="price_after[]" class="form-control price_after" required disabled="" /></td>
                                    <td>
                                        <a href="#" class="btn btn-danger remote-product">[DELETE]-</a>
                                    </td>
                                </tr>
                            </script>

                            <div class="form-group">
                                <label for="before_price">Before price</label>
                                <input readonly type="number" class="form-control" id="before_price" name="before_price">
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control required" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="bundle_start">Bundle Start</label>
                                <input type="test" class="form-control required" id="bundle_start" autocomplete="off" name="bundle_start" required>
                            </div>
                            <div class="form-group">
                                <label for="bundle_end">Bundle End</label>
                                <input type="text" class="form-control required" id="bundle_end" name="bundle_end" autocomplete="off" required>
                            </div>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="checkbox0" name="active" value="1">
                                        <label class="custom-control-label" for="checkbox0">Bundle Active</label>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" rel="stylesheet" />
@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin-asset/dist/js/jquery.czMore.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>


    <script>
        

        $('.summernote').summernote({
                height: 350, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });

            $('.inline-editor').summernote({
                airMode: true
            });
            
        $('#bundle_start').datetimepicker({
            minDate: 'today',
        });
        $('#bundle_end').datetimepicker({
            minDate: 'today',
        });
        var products = {};
        $(document).on('keyup change','.discount',function(){
            var self = $(this);
            var discount = self.val();
            var price = self.parents('tr').find('.price').val();
            if(discount.indexOf('%') >= 0){
                var percentage = discount.replace('%','');
                var discounted_amount = price*percentage/100;
                self.val(discounted_amount);
            }else{
                self.parents('tr').find('.price_after').val(price-discount);
            }
        })
        $(document).on('keyup change','.product',function(){ 
            var self = $(this);
            $.get('/big-boss/product/'+self.val(),function(res){
                if(Number(res.before_price) != 0){
                    self.parents('tr').find('.price').val(res.before_price);
                }else{
                    self.parents('tr').find('.price').val(res.price);
                }
            })
        })
        function select2() {
            //console.log('Second');
            var id = $('#category_id').val();
            $('.product').select2({
                // multiple: true,
                ajax: {
                    url: '{{ route('admin.bundles.products') }}',
                    dataType: 'json',
                    data: {category_id: id},

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

        $(document).on('change', '.quantity, .discount', function () {
            calculate();
        });

        function calculate() {
            let total = 0;
            let dtotal = 0;
            $('.product').each(function (i) {
                // if ($(this).select2('data') && $(this).select2('data')[0] && $(this).select2('data')[0].price) {
                    if(Number(products[$(this).val()].before_price) != 0){
                        var current_price = products[$(this).val()].before_price;
                    }else{
                        var current_price = products[$(this).val()].price;
                    }
                    total += current_price * $('.quantity').eq(i).val();
                    dtotal += current_price * $('.quantity').eq(i).val() - $('.discount').eq(i).val();
                // }
            })

            $('#before_price').val(total);
            $('#price').val(dtotal);
        }
 

        

        $('.add-new-product').click(function () {

            $('.no-products').hide();

            $('#products').append($('#product-row').html());

            select2();

            return false;
        });

        // image preview
        $(".bundle_image").change(function () {

            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image-preview').attr('src', e.target.result);
                    $('.image-preview').show();
                }

                reader.readAsDataURL(this.files[0]);
            }

        });
    </script>


@endsection
