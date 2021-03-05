@extends('admin.layouts.app')
@section('container')
<style>
    .loading-div{
        background: #fff;
        text-align: center;
        position: fixed;
        height: 100%;
        width: 100%;
        display: none;
    }
</style>
<div class="loading-div">
    
</div>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Categories</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Categories</a></li>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body wizard-content">

                        {!! Form::open([
                            "enctype" => "multipart/form-data",
                            'url' => route('admin.dealsection.store'), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_category_form']) !!}

                        @foreach($languages as $locale)
                            <h6>{{$locale->name}} content</h6>
                            <section>
                                <div class="form-group">
                                    <label for="name[{{$locale->locale}}]">Name {{$locale->name}} :</label>
                                    <input type="text" name="name[{{$locale->locale}}]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="slug[{{$locale->locale}}]">slug {{$locale->name}} :</label>
                                    <input type="text" name="slug[{{$locale->locale}}]" class="form-control" required>
                                </div>
                            </section>
                        @endforeach

                        <h6>Products</h6>
                        <section>

                            <h6 class="text-info">Main Info</h6>
                            <div class="form-group w-100">
                                <label for="product_ids">Categories :</label>
                                <select name="category_ids" class="form-control w-100">
                                    @if($categories->count() > 0)
                                        @foreach($cats as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('product_ids')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group w-100">
                                <label for="product_ids">Products :</label>
                                <select name="product_ids[]" class="form-control select2 products w-100" multiple>
                                    @if($products->count() > 0)
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('product_ids')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="checkbox0" name="is_active">
                                        <label class="custom-control-label" for="checkbox0">Deal Section Active</label>
                                    </div>
                                </label>
                            </div>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="in_header" name="is_home">
                                        <label class="custom-control-label" for="in_header">Show in home</label>
                                    </div>
                                </label>
                            </div>


                            <div class="form-group">
                                <label for="start_date">Start Date :</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date :</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount (Percentage):</label>
                                <input type="number" name="discount" class="form-control" required>
                            </div>

                            

                        </section>



                        {!! Form::close() !!}

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
    <style>
        .select2{
            width: 100% !important;
        }
    </style>
@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            // Fetch Categories Products
            $('select[name="category_ids"]').change(function(){
                var products_array = $('.products').val();
                console.log(typeof(typeof(products_array)))
                console.log('products array',products_array);
                $('.loading-div').show();
                $.get('/big-boss/dealsection/get_products/'+$(this).val(),function(res){
                    res.forEach(function(item){
                        if($.inArray(item,products_array) == -1){
                            products_array.push(item);
                        }
                    })
                    products_array = products_array.map(String);
                    console.log('products array2',products_array);
                    $('.select2').val(products_array);
                    console.log($('.select2').val());
                    $('.select2').trigger('change');
                    console.log($('.select2').val());
                    $('.loading-div').hide();
                })
            })
        });
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
            titleTemplate: '<span class="step">#index#</span> #title#',
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
            labels: {
                finish: "Submit"
            },
            onFinished: function (event, currentIndex) {
                $('#add_category_form').submit();
                // swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            }
        });
</script>
@endsection
