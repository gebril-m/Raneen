@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Cities</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Cities</li>
                    </ol>
                    <a href="{{route('admin.orders.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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
                            <table id="myTable" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <!-- <th>User</th> -->
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>State</th>
                                    <!-- <th>Postal Code</th> -->
                                    <th>Order Status</th>
                                    <th>Order Date</th>
                                    <!-- <th>Shipped At</th> -->
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <!-- <td>user</td> -->
                                        <td>{{ $order->first_name}}</td>
                                        <td>{{ $order->last_name}}</td>
                                        <td>{{ $order->phone  }}</td>
                                        <td>{{ $order->address  }}</td>
                                        <td>@if($order->get_state($order->state)) {{ $order->get_state($order->state)['name'] }} @endif</td>
                                        <!-- <td>{{ $order->postal_code }}</td> -->
                                        <td>
                                            @if(isset($order->status))
                                                {{ $order->status->name }}
                                            @endif
                                        </td>
                                        <td>{{$order->created_at}}</td>
                                        <!-- <td>{{$order->shipped_at}}</td> -->
                                        <td>

                                            <a href="{{route('admin.orders.show', $order->id)}}" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>
                                            @if(isset($order->status)&&!in_array(strtolower($order->status->name),$main_settings))
                                                
                                            <a href="{{route('admin.orders.edit', $order->id)}}" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>
                                            {!! Form::open(['url'=>route('admin.orders.destroy', $order->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']) !!}
                                                {{ method_field('DELETE') }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']) }}
                                                {!! Form::close() !!}
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
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
        $('#myTable').DataTable({
            "order": [[ 0, "desc" ]]
        });
    </script>

@endsection
