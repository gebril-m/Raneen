@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Users</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">users</a></li>
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
                    <div class="card-body wizard-content">

                        {!! Form::open(['url' => route('admin.users.update', $row->id), 'class' => 'tab-wizard vertical wizard-circle', 'id' => 'edit_user_form']) !!}
                            {{ method_field('PUT') }}
                            <h6>User Information</h6>
                            <section>
                                <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', $row->name, ['class' => 'form-control required']) }}
                                <label for="name" generated="true" class="error text-danger"></label>
                                @error('name')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{ Form::label('email', 'Email') }}
                                {{ Form::text('email', $row->email, ['class' => 'form-control email required']) }}
                                <label for="email" generated="true" class="error text-danger"></label>
                                @error('email')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{ Form::label('password', 'Password (Leave Empty If You Want To Keep Current)') }}
                                {{ Form::password('password', ['class' => 'form-control', 'id' => 'password']) }}
                                <label for="password" generated="true" class="error text-danger"></label>
                                @error('password')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{ Form::label('password_confirmation', 'Confirm Password') }}
                                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                <label for="password_confirmation" generated="true" class="error text-danger"></label>
                                @error('password_confirmation')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{ Form::checkbox('is_active', 1, $row->is_active) }}
                                {{ Form::label('is_active', 'Check To Active User') }}
                            </div>
                            <div class="form-group">
                                    {{ Form::label('role', 'role') }}
                                    {{ Form::select('role', $roles, $row->role_id, ['placeholder'=>'Choose Role', 'class' => 'form-control'] ) }}
                                </div>
                            <div class="form-group">
                                <label for="order_status_permissions">Order Status Permssions</label>
                                @if(count($orderstatus) > 0)
                                @php 
                                    $status_array = explode(',',$row->order_status_permissions);
                                @endphp
                                    @foreach($orderstatus as $status)
                                        <input type="checkbox" name="order_status_permissions[]" value="{{$status->id}}" @if(in_array($status->id,$status_array)) checked @endif> {{$status->name}}
                                    @endforeach
                                @endif
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

@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script type="text/javascript">
        var form = $("#edit_user_form");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                password_confirmation: {
                    equalTo: "#password"
                }
            }
        });
        form.steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: "Submit"
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {
                form.submit();
            }
        });
</script>
@endsection
