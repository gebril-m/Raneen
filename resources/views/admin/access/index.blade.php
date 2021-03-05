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
                        <li class="breadcrumb-item active">Pages</li>
                    </ol>
                    <a href="{{route('admin.roles.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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
                    <div class="card-body">
                        <div class="table-responsive m-t-10">
                            <table id="roles_table" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Childs</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rows as $row)
                                        <tr class="table-success">
                                            <td>{{$row->order}}</td>
                                            <td>{{$row->name}}</td>
                                            <th>Parent</th>
                                            <td>

                                                @forelse($row->permissions as $permission)
                                                    <span class="label label-info">{{ $permission->name }}</span>
                                                @empty
                                                    No Permissions
                                                @endforelse

                                            </td>
                                            <td>
                                                <a href="{{route('admin.roles.edit', $row->id)}}" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>

                                                {!! Form::open(['url'=>route('admin.roles.destroy', $row->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']) !!}
                                                    {{ method_field('DELETE') }}
                                                    {{ Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']) }}
                                                {!! Form::close() !!}

                                            </td>
                                        </tr>
                                        @foreach($row->permissions as $permission)
                                            <tr>
                                                <td>{{$permission->order}}</td>
                                                <td>{{$permission->name}}</td>
                                                <th>Child</th>
                                                <td>
                                                    __
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.permissions.edit', $permission->id)}}" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>

                                                    {!! Form::open(['url'=>route('admin.permissions.destroy', $permission->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']) !!}
                                                        {{ method_field('DELETE') }}
                                                        {{ Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']) }}
                                                    {!! Form::close() !!}

                                                </td>
                                            </tr>
                                        @endforeach
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
    </div>
@endsection
@section('style')
    <link href="{{asset('admin-asset/assets/node_modules/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('scripts')
    <script src="{{asset('admin-asset/assets/node_modules/datatables/datatables.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

@endsection
