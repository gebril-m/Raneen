@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Returns Order</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Returns Order</li>
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
                                    <th>Order Id</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Return Reason</th>
                                    <th>Return Method</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->order_id}}</td>
                                        <td></td>
                                        <td>{{ $order->quantity}}</td>
                                        <td>{{ $order->price }}</td>
                                        <td>
                                            @if($order->return_reason) {{$order->return_reason['name']}} @endif
                                        </td>
                                        <th>@if($order->return_bank == 1) Withdraw to Bank @else Refund to Wallet @endif</th>
                                        <td>
                                            <a href="#" class="btn waves-effect waves-light btn-outline-warning approve-return" title="edit" 
                                            data-user="{{$order->order['user_id']}}" 
                                            data-amount="{{$order->total}}" 
                                            data-notes="Return Product" 
                                            data-order="{{$order->order_id}}">Approve</a>
                                            <a href="#" class="btn waves-effect waves-light btn-outline-danger disapprove-return" data-order="{{$order->order_id}}" title="edit">Decline</a>
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
        $('.approve-return').click(function(){
            var div = $(this).parents('tr');
            var user = $(this).data('user');
            var amount = $(this).data('amount');
            var order = $(this).data('order');
            var notes = $(this).data('notes');
            var formData = {};
            formData['user'] = user;
            formData['amount'] = amount;
            formData['order'] = order;
            formData['notes'] = notes;
            $.post('/big-boss/approve-return',formData,function(res){
                if(res == 'true'){
                    div.hide();
                    alert("Return Request approved Successfull");
                }  
            })
        })
        $('.disapprove-return').click(function(){
            var div = $(this).parents('tr');
            var order = $(this).data('order');
            var formData = {};
            formData['order'] = order;
            $.post('/big-boss/disapprove-return',formData,function(res){
                if(res == 'true'){
                    div.hide();
                    alert("Return Request Declined Successfull");
                }  
            })
        })
    </script>

@endsection
