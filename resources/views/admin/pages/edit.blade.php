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
                        <form action="#" class="tab-wizard vertical wizard-circle">
                            <!-- Step Content -->
                            {{csrf_field()}}
                            @foreach($page->translations as $p)
                                @php $localeName = \App\Language::where('locale',$p->locale)->first()->name @endphp
                                <h6>{{$localeName}} content</h6>
                                <section>
                                    <div class="form-group">
                                        <h4 for="location1">Title {{$localeName}} :</h4>
                                        <input type="text" name="title_{{$p->locale}}" class="form-control" value="{{$p->name}}">
                                    </div>

                                    <textarea name="body_{{$p->locale}}" class="summernote" cols="30" rows="10">{{$p->body}}</textarea>
                                </section>
                        @endforeach
                        <!-- Step SEO -->
                            <h6>SEO Content</h6>
                            <section>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info active">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="checkbox0" name="active" @if($page->is_active) checked @endif>
                                            <label class="custom-control-label" for="checkbox0">Page Active</label>
                                        </div>
                                    </label>
                                </div>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info form">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="checkbox1" name="footer" @if($page->show_footer) checked @endif>
                                            <label class="custom-control-label" for="checkbox1">Show on footer</label>
                                        </div>
                                    </label>
                                </div>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-info form">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input type="checkbox" class="custom-control-input" id="checkbox2" name="header" @if($page->show_header) checked @endif>
                                            <label class="custom-control-label" for="checkbox2">Show on header</label>
                                        </div>
                                    </label>
                                </div>
                                <hr>
                                @foreach($page->translations as $p)
                                    @php $localeName = \App\Language::where('locale',$p->locale)->first()->name @endphp
                                    <h2>{{$localeName}} SEO</h2>
                                    <hr>
                                    <div class="form-group">
                                        <h4>Meta Title {{$localeName}}</h4>
                                        <input type="text" name="meta_title_{{$p->locale}}" class="form-control" value="{{$p->meta_title}}">
                                    </div>
                                    <div class="form-group">
                                        <h4>Meta Keywords {{$localeName}}</h4>
                                        <input type="text" name="meta_keywords_{{$p->locale}}" class="form-control" value="{{$p->meta_keywords}}">
                                    </div>
                                    <div class="form-group">
                                        <h4>Meta Description {{$localeName}}</h4>
                                        <textarea name="meta_description_{{$p->locale}}" rows="4" class="form-control">{{$p->meta_description}}</textarea>
                                    </div>
                                    <hr>
                        @endforeach
                    </div>
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
        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index# - #title#</span> ',
            labels: {
                finish: "Submit"
            },
            onFinished: function (event, currentIndex) {
                var data = $(this).serialize();
                jQuery.ajax({
                    url     : '{{ route('admin.page.update', $page->id) }}',
                    type    : 'PATCH',
                    data    : data,
                }).done(function($res) {
                    // console.log($res);
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
