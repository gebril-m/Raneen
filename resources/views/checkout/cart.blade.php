@extends('layouts.app')
@section('container')

    <base href="/">
    <app-root></app-root>

    <script src="js/runtime.js" type="module"></script>
    <script src="js/polyfills.js" type="module"></script>
    <script src="js/styles.js" type="module"></script>
    <script src="js/vendor.js" type="module"></script>
    <script src="js/main.js" type="module"></script>

{{--
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>cart</h2>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="#">cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->
<br><br>
<br><br>
<br><br>
<!-- section start -->
<!--section start-->
<section class="cart-section section-big-py-space bg-light">
    <div class="custom-container">


            <div class="row">
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">image</th>
                            <th scope="col">product name</th>
                            <th scope="col">price</th>
                            <th scope="col">quantity</th>
                            <th scope="col">action</th>
                            <th scope="col">total</th>
                        </tr>
                        </thead>

                            <tbody>
                            <tr>
                                <td>
                                    <a href="#"><img src="../assets/images/layout-3/product/1.jpg" alt="cart"  class=" "></a>
                                </td>
                                <td><a href="#">product name</a>
                                    <div class="mobile-cart-content row">
                                        <div class="col-xs-3">
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <input type="text" name="quantity" class="form-control input-number" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color">12</h2></div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color"><a href="#" class="icon"><i class="ti-close"></i></a></h2></div>
                                    </div>
                                </td>
                                <td>
                                    <h2>50</h2></td>
                                <td>
                                    <div class="qty-box">
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control input-number" value="12">
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="icon"><i class="ti-close"></i></a></td>
                                <td>
                                    <h2 class="td-color">600</h2></td>
                            </tr>
                            </tbody>

                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                        <tr>
                            <td>total price :</td>
                            <td>
                                <h2>555</h2></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-12"><a href="#" class="btn btn-normal">continue shopping</a> <a href="{{route('web.checkout.show')}}" class="btn btn-normal ml-3">check out</a></div>
            </div>


    </div>
</section>
<!--section end-->
--}}

@endsection
