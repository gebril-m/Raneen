@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Cupons</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Cupons</a></li>
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

                        {!! Form::open(['url' => route('admin.cupons.update', $row->id)]) !!}
                            {{method_field('PUT')}}

                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', $row->name, ['class' => 'form-control']) }}
                                @error('name')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('code', 'Code') }}
                                    <button type="button" class="generate btn btn-success">Generate Code</button>
                                {{ Form::text('code', $row->code, ['class' => 'form-control']) }}
                                @error('code')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('type', 'Type') }}
                                {{ Form::select('type', ['p' => 'Percentage', 'f' => 'Fixed'] , $row->type, ['class' => 'form-control']) }}
                                @error('type')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('amount', 'Amount') }}
                                {{ Form::number('amount', $row->amount, ['class' => 'form-control', 'min' => '1']) }}
                                @error('amount')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('start', 'Start Date') }}
                                {{ Form::date('start', $row->start, ['class' => 'form-control']) }}
                                @error('start')
                                <span class="error text-danger"> {{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('end', 'End Date') }}
                                {{ Form::date('end', $row->end, ['class' => 'form-control']) }}
                                @error('end')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('usage_times', 'Usage Times') }}
                                {{ Form::number('usage_times', $row->usage_times, ['class' => 'form-control', 'min' => '1']) }}
                                @error('usage_times')
                                <span class="error text-danger"> {{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('user_usage_times', 'User Usage Times') }}
                                {{ Form::number('user_usage_times', $row->user_usage_times, ['class' => 'form-control', 'min' => '1']) }}
                                @error('user_usage_times')
                                <span class="error text-danger"> {{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::label('min_order', 'Minimum Order') }}
                                {{ Form::number('min_order', $row->min_order, ['class' => 'form-control', 'min' => '1']) }}
                                @error('min_order')
                                <span class="error text-danger"> {{$message}}</span>
                                @enderror
                            </div>
                            

                            <hr>
                            
                            <div class="form-group">
                                {{ Form::label('category_id', 'Categories') }}
                                <select name="category_id[]" class="form-control select2" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($row->categories->search($category->id) !== false) ? 'selected' : ''}}> {{ $category->name }} </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                {{ Form::label('product_id', 'Products') }}
                                <select name="product_id[]" class="form-control select2" multiple>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ ($row->products->search($product->id) !== false) ? 'selected' : ''}}> {{ $product->name }} </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="error text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                {{ Form::checkbox('is_active', 1, $row->is_active) }}
                                {{ Form::label('is_active', 'Check To Active') }}
                            </div>
                            <div class="form-group">
                                Cupon Usage: {{$log}}
                            </div>

                            <div class="form-group">
                                {{ Form::submit('Submit', ['class' => 'btn btn-dark']) }}
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

@endsection
@section('scripts')

    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="{{asset('admin-asset/dist/js/generator.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
