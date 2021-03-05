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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body wizard-content">

                        {!! Form::open([
                            "enctype" => "multipart/form-data",
                            'url' => route('admin.products.store'), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'add_category_form']) !!}

                        @foreach($languages as $locale)
                            <h6>{{$locale->name}} content</h6>
                            <section>
                                <div class="form-group">
                                    <label for="name[{{$locale->locale}}]">Name {{$locale->name}} :</label>
                                    <input type="text" name="name[{{$locale->locale}}]" class="form-control required" value="{{ old("name." . $locale->locale) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="slug[{{$locale->locale}}]">Slug {{$locale->name}} :</label>
                                    <input type="text" name="slug[{{$locale->locale}}]" class="form-control required" value="{{ old("slug." . $locale->locale) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="description[{{$locale->locale}}]">Description {{$locale->name}} :</label>
                                    <textarea id="description[{{$locale->locale}}]" name="description[{{$locale->locale}}]" class="form-control summernote" cols="30" rows="10">{{ old("description." . $locale->locale) }}</textarea>
                                </div>
                            </section>
                        @endforeach

                        <h6>Stock</h6>
                        <section>
                          @include('admin.products.accordians.stock')
                        </section>

                        <h6>Images</h6>
                        <section>
                        @include('admin.products.accordians.images')
                        </section>

                        <h6>Meta Content</h6>
                        <section>
                        @include('admin.products.accordians.main-info')
                        </section>

                        <h6>Attributes</h6>
                        <section>
                        @include('admin.products.accordians.attributes')

                        </section>
                        <div id="error"  role="alert">

                        </div>

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin-asset/dist/js/jquery.czMore.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <script>
        $(function() {



            $('.mdb-select').selectpicker();

            jQuery('#hot_starts_at').datetimepicker({
                minDate: 'today',
            });
            jQuery('#hot_ends_at').datetimepicker({
                minDate: 'today',
            });
            jQuery('#sale_ends_at').datetimepicker({
                minDate: 'today',
            });

            $('#stock').change(function () {
                $('#minimum_stock').prop('max', $(this).val())
            })

            $('#price').change(function () {
                $('#before_price').prop('max', $(this).val())
                $('#hot_price').prop('max', $(this).val())
            })

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
                    $('#is_combo').prop('checked', false).trigger('change');
                    $('[data-show="on_sale"]').slideDown();
                } else {
                    $('[data-show="on_sale"]').slideUp();
                }
            });

            $('#is_hot').change(function () {
                if($(this).is(':checked')) {
                    $('#on_sale').prop('checked', false).trigger('change');
                    $('#is_combo').prop('checked', false).trigger('change');
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
            saveState: true,
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
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
            onFinished: function (event, currentIndex) {
                var quantity =0
                var stock = $('#stock').val();
                var inputs = $(".attribute_values");
                for(var i = 0; i < inputs.length; i++){
                    quantity += parseFloat($(inputs[i]).val());
                }
                if(quantity > stock){
                    $("#error").addClass("alert alert-danger").text("The Quantity for Attributes Must Be Less Than The Whole Stock Which is "+stock);
                }
                else if(isNaN(quantity) == true){
                    $("#error").addClass("alert alert-danger").text("Quantity Must Be a Number");
                }
                else{

                    $("#error").removeClass("alert alert-danger").text("");
                    $('#add_category_form').submit();
                }




                //swal("Form Submitted!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            }
        });


        $("#czContainer").czMore(
            {
                styleOverride:true,
                onAdd: function(index) {
                    $('.select2').select2();
	            },
            }
        );

        $(document).on('change', '.optionsSelect', function(){
            var self = $(this);
            var id = self.children("option:selected").val();
            $.ajax({
            url: '{{ route('admin.options.values') }}',
            type: "POST",
            data: {id: id},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
            }).done(function(data){
                if(data !== '0'){
                    self.closest('.recordset').find('.optionValuesContainer').html(data);
                } else {
                    self.closest('.recordset').find('.optionValuesContainer').html('<input type="hidden" name="options_values[]" value="">');
                }
            });

        });

    </script>
    <script>
    var count = 1;
        function addNewAtteibute(cat_ids)
        {
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
        //category_id
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

@endsection
