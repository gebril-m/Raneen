<!DOCTYPE html>
<html lang="en">

@include('website.components.head')

<body class="cms-index-index cms-home-page" style="overflow: hidden">
<input type="hidden" id="cart_url" value="{{url('cart')}}" />
    <!-- loader -->
  <section class="overlay-loading">
    <div class="sk-cube-grid">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
        <div class="sk-cube sk-cube3"></div>
        <div class="sk-cube sk-cube4"></div>
        <div class="sk-cube sk-cube5"></div>
        <div class="sk-cube sk-cube6"></div>
        <div class="sk-cube sk-cube7"></div>
        <div class="sk-cube sk-cube8"></div>
        <div class="sk-cube sk-cube9"></div>
    </div>
</section>
<!-- start section loading -->
<section class="b-g">

@include('website.components.mobile-menu')

<div id="page">
    @yield('content')
</div>
</section>

@include('website.components.scripts')

<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content quick-view-modal">
          <div class="modal-body">
          <i class="fa fa-window-close  q-close"  style="font-size:30px; color:#b22827 ;"> </i>
              <div id="quick_view_popup-content">
      <div style="width:auto;height:auto;overflow: auto;position:relative;">
        <div class="product-view-area">
          <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
            <div class="icon-sale-label sale-left">{{ __('words.product_details') }}</div>
            <div class="large-image quick-view-img"> <a href="{{asset('/assets/images/layout-2/product/a1.jpg')}}" class="cloud-zoom quick-view-url" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20" style="position: relative; display: block;"> <img class="zoom-img img-thumbnail" src="../images/products/product-1.jpg" style="display: block; visibility: visible;"> </a> </div>
            <div class="flexslider flexslider-thumb" style="display: none">
              
            <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="previews-list slides" style="width: 1000%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                <li style="width: 100px; float: left; display: block;"><a href="../images/products/product-1.jpg" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '../images/products/product-1.jpg' "><img src="../images/products/product-1.jpg" alt="Thumbnail 2" draggable="false"></a></li>
                <li style="width: 100px; float: left; display: block;"><a href="../images/products/product-8.jpg" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '../images/products/product-8.jpg' "><img src="../images/products/product-8.jpg" alt="Thumbnail 1" draggable="false"></a></li>
                <li style="width: 100px; float: left; display: block;"><a href="../images/products/product-2.jpg" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '../images/products/product-2.jpg' "><img src="../images/products/product-2.jpg" alt="Thumbnail 1" draggable="false"></a></li>
                <li style="width: 100px; float: left; display: block;"><a href="../images/products/product-3.jpg" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '../images/products/product-3.jpg' "><img src="../images/products/product-3.jpg" alt="Thumbnail 2" draggable="false"></a></li>
                <li style="width: 100px; float: left; display: block;"><a href="../images/products/product-4.jpg" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '../images/products/product-4.jpg' "><img src="../images/products/product-4.jpg" alt="Thumbnail 2" draggable="false"></a></li>
              </ul></div><ul class="flex-direction-nav"><li><a class="flex-prev flex-disabled" href="#" tabindex="-1"></a></li><li><a class="flex-next" href="#"></a></li></ul></div>
            
            <!-- end: more-images --> 
            
          </div>
          <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7">
            <div class="product-details-area">
              <div class="product-name">
                <h1 data-type="name">Donec Ac Tempus</h1>
              </div>
              <div class="price-box">
                <p class="special-price"> <span class="price-label">Price</span> <span class="price" data-type="price" value=""> $0 </span> </p>
                <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"data-type="before_price" value=""> $0.99 </span> </p>
              </div>
              <div class="ratings">
                <div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                <p class="availability in-stock p-r">{{__('Product.Availability')}}: <span data-type="stock_status">In Stock</span></p>
              </div>
              <div class="short-description">
                <h2>Quick Overview</h2>
                <p data-type="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. </p>
              </div>
              <div class="product-color-size-area" style="display: none">
                <div class="color-area">
                  <h2 class="saider-bar-title cole" style="padding: 15px;">Color</h2>
                  <div class="color content ">
                    <ul>
                      <li><a href="#"></a></li>
                      <li><a href="#"></a></li>
                      <li><a href="#"></a></li>
                      <li><a href="#"></a></li>
                      <li><a href="#"></a></li>
                      <li><a href="#"></a></li>
                    </ul>
                  </div>
                </div>
                <div class="size-area" style="display: none">
                  <h2 class="saider-bar-title  cole" style="padding: 15px;">Size</h2>
                  <div class="size content">
                    <ul>
                      <li><a href="#">S</a></li>
                      <li><a href="#">L</a></li>
                      <li><a href="#">M</a></li>
                      <li><a href="#">XL</a></li>
                      <li><a href="#">XXL</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="product-variation">
                  <div class="cart-plus-minus">
                    <label for="qty">Quantity:</label>
                    <div class="numbers-row">
                      <div onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;" class="dec qtybutton"><i class="fa fa-minus">&nbsp;</i></div>
                      <input type="text" class="qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                      <div onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="inc qtybutton"><i class="fa fa-plus">&nbsp;</i></div>
                    </div>
                  </div>
                  <button class="button pro-add-to-cart website_addtocart" style="margin: 5px 0; padding: 4px 8px" title="Add to Cart" type="button" id="productId" productId=""><span><i class="fa fa-shopping-basket"></i> {{__('User.Add To Cart')}}</span></button>
              </div>
              <div class="product-cart-option">
                <ul>
                  <li class="add_to_wishlist"><a href="#"><i class="fa fa-heart ti-heart" id="productId" productId=""></i><span>{{__('home.Add To WishList')}}</span></a></li>
                  <li><a href="#" class="view-btn-details"><i class="fa fa-share"></i><span>{{__('home.View Details')}}</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!--product-view--> 
        
      </div>
    </div>
          </div>
      </div>
  </div>
</div>


<!-- (Sherif) Please Remove This, I Left it to be refrence until we finish this view (Sherif) -->
{{--<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content quick-view-modal">
          <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <div class="row">
                  <div class="col-lg-4 col-xs-12">
                      <div class="quick-view-img">
                        <a href="#" class="quick-view-url">
                          <img src="{{asset('/assets/images/layout-2/product/a1.jpg')}}" style="width:100%" alt="" class="img-fluid img-thumbnail img-responsive">
                        </a>
                      </div>
                  </div>
                  <div class="col-lg-8 rtl-text">
                      <div class="product-right product-dsec ">
                          <h4 data-type="name" style="color: #b22827;font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;">Women Pink Shirt</h4><hr>
                          <h5 style="font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;font-size: 24px;font-weight: normal;border: 1px dashed;width: 100%;display: block;padding: 10px;">$<span class="product-right_price" data-type="price" value=""> 32.96 </span></h5><hr>
                          <div class="border-product prodect_details_read">
                              <h6 class="product-title" style="color: #b22827;font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;font-size: 20px;margin-bottom: 15px;">{{ __('words.product_details') }}</h6>
                              <p class="prodect_details_read" data-type="description" style="font-family: Segoe UI,Frutiger,Frutiger Linotype,Dejavu Sans,Helvetica Neue,Arial,sans-serif;">Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
                          </div>
                          
                          <hr>
                         

                          <div class="row">
                            <div class="product-buttons">
                              <div class="col-lg-6"><a href="javascript:void(0)" style="float:right;background: #b22827;color: #fff;padding: 7px 22px;border: 1px #b22827 solid;" class="btn btn-normal addToCart" id="productId" productId="">add to cart</a></div>
                              
                              <div class="col-lg-6"><a href="javascript:void(0)" style="float:left;background: #b22827;color: #fff;padding: 7px 22px;border: 1px #b22827 solid;" class="btn btn-normal pro-add-to-cart view-btn-details">view detail</a></div>
                            </div>
                          </div>
                          
                           
                      </div>

                  </div>
              </div>
          </div>
      </div>
  </div>
</div>--}}

</body>