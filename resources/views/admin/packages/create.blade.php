@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Packages</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Packages</a></li>
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

                        {!! Form::open(['url' => route('admin.packages.store'), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_package_form']) !!}

                        @foreach($languages as $locale)
                            <h6>{{$locale->name}} content</h6>
                            <section>
                                <div class="form-group">
                                    <label for="name[{{$locale->locale}}]">Name {{$locale->name}} :</label>
                                    <input type="text" value="{{ old('name.' . $locale->locale) }}" name="name[{{$locale->locale}}]" class="form-control required" required>
                                </div>

                                <div class="form-group">
                                    <label for="description[{{$locale->locale}}]">Description {{$locale->name}} :</label>
                                    <textarea id="description[{{$locale->locale}}]" name="description[{{$locale->locale}}]" class="form-control summernote required" required cols="30" rows="10">{{ old('description.' . $locale->locale) }}</textarea>
                                </div>
                            </section>
                        @endforeach

                        <h6>Meta Content</h6>

                        <section>

{{--                            <div class="form-group">--}}
{{--                                <label for="price">Price: </label>--}}
{{--                                <input type="number" id="price" name="price" class="form-control required" required>--}}
{{--                            </div>--}}

{{--                            <div class="form-group">--}}
{{--                                <label for="duration">Duration: </label>--}}
{{--                                <input type="number" id="duration" name="duration" class="form-control required" required>--}}
{{--                            </div>--}}

                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-info active">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" class="custom-control-input" id="checkbox0" name="active">
                                        <label class="custom-control-label" for="checkbox0">Packages Active</label>
                                    </div>
                                </label>
                            </div>

                            <hr>

                            @foreach($languages as $locale)
                                <h6 class="text-info">{{$locale->name}} SEO</h6>
                                <section>
                                    <div class="form-group">
                                        <label for="meta_title[{{$locale->locale}}">Meta Title {{$locale->name}}:</label>
                                        <input type="text" name="meta_title[{{$locale->locale}}]" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords[{{$locale->locale}}]">Meta Keywords {{$locale->name}} :</label>
                                        <input type="text" name="meta_keywords[{{$locale->locale}}]" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_keywords[{{$locale->locale}}]">Meta Description {{$locale->name}} :</label>
                                        <textarea name="meta_keywords[{{$locale->locale}}]" rows="4" class="form-control"></textarea>
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

    <script>
        $(function() {

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

    <script type="text/javascript">
        //Custom design form example
        //Custom design form example
        var form = $(".tab-wizard");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
        });

        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            // onStepChanging: function (event, currentIndex, newIndex)
            // {
            //     // Allways allow previous action even if the current form is not valid!
            //     if (currentIndex > newIndex)
            //     {
            //         return true;
            //     }
            //     // Needed in some cases if the user went back (clean up)
            //     if (currentIndex < newIndex)
            //     {
            //         // To remove error styles
            //         form.find(".body:eq(" + newIndex + ") label.error").remove();
            //         form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            //     }
            //     form.validate().settings.ignore = ":disabled,:hidden";
            //     return form.valid();
            // },
            labels: {
                finish: "Submit"
            },
            onFinished: function (event, currentIndex) {
                $('#add_package_form').submit();
                // swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            }
        });
    </script>
@endsection
