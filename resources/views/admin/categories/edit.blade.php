@extends('admin.layouts.app')
@section('container')
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

                        {!! Form::open(["enctype" => "multipart/form-data",'url' => route('admin.categories.update', $row->id), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_category_form']) !!}
                        {{ method_field('PATCH') }}
                        @foreach($languages as $locale)
                            <h6>{{$locale->name}} content</h6>
                            <section>
                                <div class="form-group">
                                    <label for="name[{{$locale->locale}}]">Name {{$locale->name}} :</label>
                                    <input type="text" name="name[{{$locale->locale}}]" value="{{ $row->translate($locale->locale)->name ?? '' }}" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="slug[{{$locale->locale}}]">Slug {{$locale->name}} :</label>
                                    <input type="text" name="slug[{{$locale->locale}}]" value="{{ $row->translate($locale->locale)->slug ?? '' }}" class="form-control" required>
                                </div>
                            </section>
                        @endforeach

                        <h6>Meta Content</h6>
                        <section>

                            <h6 class="text-info">Main Info</h6>

                            <div class="form-group">
                                <label for="parent_id">Parent Category</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="0">No parent</option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}"
                                        @if($row->parent_id == $id) selected @endif
                                        >{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="return_policy">Return Policy :</label>
                                <input type="text" name="return_policy" class="form-control" value="{{$row->return_policy}}" required>
                            </div>
                            <div class="form-group">
                                <label for="return_policy">Arrange :</label>
                                <input type="number" name="arrange" class="form-control" min="0" value="{{$row->arrange}}">
                            </div>
                            <div class="form-group">
                                <label for="shipping_type">Shipping Type :</label>
                                <select name="shipping_type" class="form-control">
                                    <option value="0" @if($row->shipping_type == 0) selected @endif>Piece</option>
                                    <option value="1" @if($row->shipping_type == 1) selected @endif>Total</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shipping_value">Shipping Value :</label>
                                <input type="number" name="shipping_value" class="form-control" min="0" value="{{$row->shipping_value}}">
                            </div>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" @if($row->is_active) checked @endif id="checkbox0" name="active">
                                        <label class="custom-control-label" for="checkbox0">Category Active</label>
                                    </div>
                                </label>
                            </div>

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" @if($row->in_header) checked @endif id="in_header" name="in_header">
                                        <label class="custom-control-label" for="in_header">Show in header</label>
                                    </div>
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <img class="thumbnail" style="width: 100px; height: 100px;" src="{{ image('category', $row->icon) }}" alt="">
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        <input type="file" name="icon" id="icon" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <img class="thumbnail" style="width: 100px; height: 100px;" src="{{ image('category', $row->banner) }}" alt="">
                                </div>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label for="banner">Banner</label>
                                        <input type="file" name="banner" id="banner" class="form-control">
                                    </div>
                                </div>
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

@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
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
