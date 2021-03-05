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
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Pages</a></li>
                        <li class="breadcrumb-item active">create</li>
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
                    <div class="card-body wizard-content ">
                        <h4 class="card-title">
                            Page Information
                        </h4>
                        <form action="{{ route('admin.page.store') }}" method="post" class="tab-wizard vertical wizard-circle">
                            <!-- Step Content -->
                            {{csrf_field()}}
                            @foreach($len as $locale)
                            <h6>{{$locale->name}} content</h6>
                            <section>
                                    <div class="form-group">
                                        <h4 for="location1">Title {{$locale->name}} :</h4>
                                        <input type="text" name="title_{{$locale->locale}}" class="form-control" required>
                                        <label for="title_{{$locale->locale}}" generated="true" class="error text-danger"></label>
                                        @error('title_{{$locale->locale}}')
                                        <span class="text-danger">
                                        {{$message}}
                                         </span>
                                        @enderror

                                    </div>

{{--                                <div id ="body_{{$locale->locale}}" ></div>--}}
                                <textarea id ="body_{{$locale->locale}}" name="body_{{$locale->locale}}" class="summernote" cols="30" rows="10" required></textarea>
                                <label for="body_{{$locale->locale}}" generated="true" class="error text-danger"></label>
                                @error('body_{{$locale->locale}}')
                                <span class="text-danger">
                                        {{$message}}
                                         </span>
                                @enderror

                            </section>
                            @endforeach
                            <!-- Step SEO -->
                            <h6>SEO Content</h6>
                            <section>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info active">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="checkbox0" name="active">
                                            <label class="custom-control-label" for="checkbox0">Page Active</label>
                                        </div>
                                    </label>
                                </div>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info form">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="checkbox1" name="footer">
                                            <label class="custom-control-label" for="checkbox1">Show on footer</label>
                                        </div>
                                    </label>
                                </div>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info form">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="checkbox2" name="header">
                                            <label class="custom-control-label" for="checkbox2">Show on header</label>
                                        </div>
                                    </label>
                                </div>
                                <hr>
                            @foreach($len as $locale)
                                       <h2>{{$locale->name}} SEO</h2>
                                    <hr>
                                    <div class="form-group">
                                        <h4>Meta Title {{$locale->name}}</h4>
                                        <input type="text" name="meta_title_{{$locale->locale}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <h4>Meta Keywords {{$locale->name}}</h4>
                                        <input type="text" name="meta_keywords_{{$locale->locale}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                            <h4>Meta Description {{$locale->name}}</h4>
                                            <textarea name="meta_description_{{$locale->locale}}" rows="4" class="form-control"></textarea>
                                        </div>
                                    <hr>
                                        @endforeach
                            </section>
                        </form>
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
{{--    <script src="{{asset('admin-asset/assets/ckeditor4/ckeditor.js')}}"></script>--}}
{{--    <script src="{{asset('admin-asset/assets/ckeditor4/sample.js')}}"></script>--}}

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

    <script>
        //Custom design form example
        var form = $(".tab-wizard");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
        });

        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index# - #title#</span> ',
            labels: {
                finish: "Submit"
            },
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

            // onStepChanging: function (event, currentIndex, newIndex)
            // {
            //     form.validate().settings.ignore = ":disabled,:hidden";
            //     return form.valid();
            // },
            // onFinishing: function (event, currentIndex)
            // {
            //     form.validate().settings.ignore = ":disabled";
            //     return form.valid();
            // },

            onFinished: function (event, currentIndex) {
                var form = new FormData( this );
                // form.append('body_en', en_editor.getData());
                // form.append('body_ar', ar_editor.getData());
                var token = $('input[name="_token"]').val();

                jQuery.ajax({
                    url     : '{{ route('admin.page.store') }}',
                    type    : 'POST',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data    : form,
                }).done(function($res) {
                    console.log($res);
                    swal("Page Submitted!", $res.message);
                    window.location.assign('{{ route('admin.page.index') }}');
                    // Handle Success
                }).fail(function(xhr, status, error) {
                    console.log('faild');
                    // Handle Failure
                });
                console.log(data);

            }

        });
    </script>

@endsection
@section('style')
@endsection
