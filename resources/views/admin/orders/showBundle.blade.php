@extends('admin.layouts.app')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>{{$bundle->name}}</h3>
                </div>
                <div class="relative-table">
                    <div class="blocks m-t-0">
                        <ul class="block-detail">
                            <li>
                                <div class="parameter">Unit</div>
                                <div class="value">{{ ceil($bundle->pivot->price) }}</div>
                            </li>
                            <li>
                                <div class="parameter">Quantity</div>
                                <div class="value">{{$bundle->pivot->quantity}}</div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3>Bundle Products</h3>
        <div class="table-responsive m-t-10">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>Item No.</th>
                    <th>Product Name</th>
                    <th>Dimensions (L x W x H)</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                    <th>Image</th>
                    <th>Inventory</th>
                    
                    
                    {{--                                    <th>Status</th>--}}
                </tr>
                </thead>
                <tbody>
                    <?php $totalDiscount=0; ?>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->item_id}}</td>
                        <td>{{$product->name}}
                        

                        </td>
                        <td>{{ $product->length }} x {{ $product->width }} x {{ $product->height }} </td>
                        <td>{{ ceil($product->price) }}</td>
                       
                        <td>{{$product->product_of_bundle($product->id,$bundle->id)->quantity}}</td>
                        <td>{{ $product->product_of_bundle($product->id,$bundle->id)->discount }}</td>
                        <td>{{ ceil($product->price-$product->product_of_bundle($product->id,$bundle->id)->discount) * $product->product_of_bundle($product->id,$bundle->id)->quantity}}</td>
                        <td><img  src="{{ url('image/product/'.$product->get_image($product->id)) }}" style="height: 70px;" alt="Product"> </td>
                        <?php 
                        $totalDiscount+=$product->getFinalDiscountPriroty(); ?>
                        <td>
                            @if(sizeof($product->inventories) > 0)
                                <select name="inventory[{{ $product->id }}]" id="inventory" class="form-control" required>
                                    <option disabled selected>- SELECT INVENTORY</option>
                                    @foreach($product->inventories as $inventory)
                                        <option value="{{ $inventory->id }}" @if(in_array($order->state,explode(',',$inventory->areas))) selected @endif>{{ $inventory->name }} ({{ $inventory->pivot->quantity }})</option>
                                    @endforeach
                                </select>
                            @else
                                NO INVENTORIES
                            @endif
                        </td>
                        
                        
                        {{--                                        <td>Delivered</td>--}}
                    </tr>
                @endforeach

                </tbody>
               <!--  -->
            </table>
        </div>
    </div>
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
@endsection
