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
                        <li class="breadcrumb-item "><a href="javascript:void(0)">Users</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
        <!--
            "id": 2,
"name": "amir",
"email": "amir@gmail.com",
"email_verified_at": null,
"is_admin": 0,
"is_active": 0,
"created_at": "2019-12-09 10:00:16",
"updated_at": "2019-12-09 10:00:16",
"details": {
    "id": 2,
    "first_name": "Paki",
    "last_name": "Hendricks",
    "phone": 96,
    "country_id": 2,
    "address": "Cupiditate rerum mod",
    "city_id": 2,
    "state": "Consequatur Dolor l",
    "postal_code": 36,
    "user_id": 2,
    "created_at": "2019-12-11 01:44:49",
    "updated_at": "2019-12-11 01:46:24"
        -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Person Info</h3>
                        <hr>
                        
                        <h4>Name</h4>
                        <p>
                            {{$row->name}}
                        </p>

                        <h4>Email</h4>
                        <p>
                            {{$row->email}}
                        </p>

                        <h4>First Name</h4>
                        <p>
                            {{ (isset($row->details->first_name)) ? $row->details->first_name : '-' }}
                        </p>

                        <h4>Last Name</h4>
                        <p>
                            {{ (isset($row->details->last_name)) ? $row->details->last_name : '-' }}
                        </p>

                        <h4>Phone</h4>
                        <p>
                            {{ (isset($row->details->phone)) ? $row->details->phone : '-' }}
                        </p>

                        <h4>Address</h4>
                        <p>
                            {{ (isset($row->details->address)) ? $row->details->address : '-' }}
                        </p>

                        <h4>Email</h4>
                        <p>
                            {{ (isset($row->details->email)) ? $row->details->email : '-' }}
                        </p>

                        <h4>State</h4>
                        <p>
                            {{ (isset($row->details->state)) ? $row->get_state($row->details->state)->name : '-' }}
                        </p>

                        <h4>Postal Code</h4>
                        <p>
                            {{ (isset($row->details->postal_code)) ? $row->details->postal_code : '-' }}
                        </p>

                        <h4>Wallet <span class="badge badge-info">{{$row->wallet($row->id)->sum('amount')}}</span></h4>
                        <p>
                            @if(count($row->wallet($row->id)) > 0)
                                <table class="table" id="myTable3">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Notes</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($row->wallet($row->id) as $item)
                                        <tr>
                                            <td>{{$item->amount}}</td>
                                            <td>{{$item->notes}}</td>
                                            <td>{{$item->created_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            0
                            @endif
                        </p>

                        <h4>Points <span class="badge badge-info">{{$row->points($row->id)->sum('points')}}</span></h4>
                        <p>
                            
                        @if(count($row->points($row->id)) > 0)
                                <table class="table" id="myTable2">
                                    <thead>
                                        <tr>
                                            <th>Points</th>
                                            <th>Order Total</th>
                                            <th>Order Number</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($row->points($row->id) as $item)
                                        <tr>
                                            <td>{{$item->points}}</td>
                                            <td>{{$item->total}}</td>
                                            <td>{{$item->order_id}}</td>
                                            <td>{{$item->created_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            0
                            @endif
                        </p>

                        <h4>Orders</h4>
                        <p>
                            
                        @if(count($row->orders($row->id)) > 0)
                                <table class="table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Products</th>
                                            <th>Total</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($row->orders($row->id) as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>
                                                @foreach($item->products as $product)
                                                    <span class="badge badge-info">{{$product->name}}</span>
                                                @endforeach
                                            </td>
                                            <td>{{$row->order_total($item->id)}}</td>
                                            <td>{{$item->created_at}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            0
                            @endif
                        </p>

                        <hr>
                        <a href="{{route('admin.customers.edit', $row->id)}}" class="btn btn-dark">
                            Edit This User
                        </a>
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
    <link href="{{asset('admin-asset/assets/node_modules/wizard/steps.css')}}" rel="stylesheet">
    <!--alerts CSS -->
    <link href="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-asset/dist/css/custom.css')}}" rel="stylesheet">

    <!-- Theme included stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('admin-asset/assets/node_modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.steps.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/wizard/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin-asset/assets/node_modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script>
    $(document).ready( function () {
        $('#myTable').DataTable();
        $('#myTable2').DataTable();
        $('#myTable3').DataTable();
    } );
</script>
@endsection
