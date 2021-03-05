@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Withdraws</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Withdraws</li>
                    </ol>
                    <!-- <a href="{{route('admin.orders.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a> -->
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
                                    <th>User</th>
                                    <th>Order Line (Product)</th>
                                    <th>Amount</th>
                                    <th>Bank Name</th>
                                    <th>Bank Number</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($withdraws) > 0)
                                @foreach($withdraws as $withdraw)
                                    <tr>
                                        <td>{{$withdraw->user->name}}</td>
                                        <td>{{ ( $withdraw->order_product($withdraw->order_line_id) ? $withdraw->order_product($withdraw->order_line_id)->product->name : '' )}}</td>
                                        <td>{{ $withdraw->amount}}</td>
                                        <td>{{ $withdraw->bank_name }}</td>
                                        <td>{{ $withdraw->bank_number }}</td>
                                        <td>{{ $withdraw->notes }}</td>
                                        <td>{{ $withdraw->status }}</td>
                                        {{-- <td>
                                            <a href="#" class="btn waves-effect waves-light btn-outline-warning approve-return" title="edit" 
                                            data-user="{{$order->order['user_id']}}" 
                                            data-amount="{{$order->total}}" 
                                            data-notes="Return Product" 
                                            data-order="{{$order->order_id}}">Approve</a>
                                            <a href="#" class="btn waves-effect waves-light btn-outline-danger disapprove-return" data-order="{{$order->order_id}}" title="edit">Decline</a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                                @endif
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
