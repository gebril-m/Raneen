@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Brands</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                    <form method="post" enctype="multipart/form-data" action="{{ route('admin.brands.import') }}" class="import-form" style="border: 1px solid #DDD; padding: 6px 10px;margin-left: 20px; border-radius: 5px; display: none">
                        {{ csrf_field() }}
                        <input type="file" name="file" required>
                        <input type="submit" class="btn #btn-sm btn-cyan m-l-15" value="Import">
                    </form>
                    <a href="#" class="btn btn-cyan import-btn d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Import</a>
                    <a href="{{route('admin.brands.export')}}" class="btn btn-success d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Export</a>
                    <a href="{{route('admin.brands.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->

        @if (session('rules_validation'))
            <div class="alert alert-danger">
                <ul>
                    @foreach(session('rules_validation') as $validate)
                        <li>{{ $validate }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive m-t-10">
                            <table id="myTable" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Logo</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($rows as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->name}}</td>
                                        <td><img src="{{$row->logo_thumb}}" style="width: 64px;" class="thumbnail" alt=""></td>
                                        <td>
{{--                                            <a href="{{route('admin.brands.show', $row->id)}}" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>--}}
                                            <a href="{{route('admin.brands.edit', $row->id)}}" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>

                                            {!! Form::open(['url'=>route('admin.brands.destroy', $row->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']) !!}
                                            {{ method_field('DELETE') }}
                                            {{ Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']) }}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            No Data Available
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
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
    <link href="{{asset('admin-asset/assets/node_modules/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin-asset/assets/node_modules/datatables/datatables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script>

        $('.import-btn').click(function () {
            $('.import-btn').remove();
            $('.import-form').fadeIn();
            return false;
        })
        $('#myTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    </script>

@endsection
