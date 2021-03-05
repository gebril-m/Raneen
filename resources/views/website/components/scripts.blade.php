<!-- jquery js --> 
<script type="text/javascript" src="{{ asset('website/js/jquery.min.js') }}"></script> 

<!-- bootstrap js --> 
<script type="text/javascript" src="{{ asset('website/js/bootstrap.min.js') }}"></script> 

<!-- owl.carousel.min js --> 
<script type="text/javascript" src="{{ asset('website/js/owl.carousel.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('website/js/owl.carousel.rtl.js') }}"></script> 

<!-- jquery.mobile-menu js --> 
<script type="text/javascript" src="{{ asset('website/js/mobile-menu.js') }}"></script> 

<!--cloud-zoom js --> 
<script type="text/javascript" src="{{ asset('website/js/cloud-zoom.js') }}"></script> 

<!-- flexslider js --> 
<script type="text/javascript" src="{{ asset('website/js/jquery.flexslider.js') }}"></script> 
<!--jquery-ui.min js --> 
<script type="text/javascript" src="{{ asset('website/js/jquery-ui.js') }}"></script> 
<!-- <script type="text/javascript" src="{{ asset('website/js/theme.js') }}"></script>  -->

<!-- main js --> 
<script type="text/javascript" src="{{ asset('website/js/main.js') }}"></script> 

<!-- countdown js --> 
<script type="text/javascript" src="{{ asset('website/js/countdown.js') }}"></script> 

<!-- Slider Js --> 
<script type="text/javascript" src="{{ asset('website/js/revolution-slider.js') }}"></script> 
<script src="{{asset('website/js/jquery.jscroll.min.js')}}"></script>
<!-- <script src="{{asset('/assets/js/bootstrap-notify.min.js')}}"></script> -->
<!-- <script src="{{asset('website/js/notify.js')}}"></script> -->
<script type="text/javascript" src="https://www.jqueryscript.net/demo/Simple-Flexible-jQuery-Alert-Notification-Plugin-notify-js/js/notify.js"></script>
<script type="text/javascript" src="https://www.jqueryscript.net/demo/Simple-Flexible-jQuery-Alert-Notification-Plugin-notify-js/js/prettify.js"></script>

<script src="{{asset('/assets/js/modal.js')}}"></script>
<script src="{{asset('website/js/cart.js')}}"></script>
<script src="{{asset('website/js/wishlist.js')}}"></script>
<script src="{{asset('website/js/checkout.js')}}"></script>
<script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
<script src="{{asset('website/js/filter.js')}}"></script>
<script src="{{asset('website/js/compare.js')}}"></script>
<script src="{{asset('website/js/product.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
$("#cupon_submitter").click(function(){
  var id = $('#cupon_code').val();
  if(id !== ''){
    var url = '/cupon/apply/' + id;
    window.location = url;
  } else {
    $('#cupon_code').focus();
  }
});
</script>
<script>
window.onload = function() {
    var latlng = new google.maps.LatLng(30.0444, 31.2357);
    var map = new google.maps.Map(document.getElementById('map'), {
        center: latlng,
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: 'Set lat/lon values for this property',
        draggable: true
    });
    google.maps.event.addListener(marker, 'dragend', function(a) {
        console.log(a);
        var div = document.createElement('div');
        var lat = a.latLng.lat().toFixed(4);
        var lng = a.latLng.lng().toFixed(4);
        $('#lat_input').val(lat);
        $('#lng_input').val(lng);
    });
};
</script>
<script>

    $('#receive_from_location').on('change', function () {
        if ($(this).is(':checked')) {
            $('#location-container').show();
        } else {
            $('#location-container').hide();
        }
    });

    $('#send_to_home').on('change', function () {
        if ($(this).is(':checked')) {
            $('#location-container').hide();
        } else {
            $('#location-container').show();
        }
    });

    // Form Validation
    // var validationform=[]
    // function checkForm(isValid){
    //     console.log(isValid)
    //     if (!isValid) {
    //         validationform.push(true)
    //     } 
    // }
    bootstrapValidate(['[name="first_name"]','[name="last_name"]'],'min:3: enter at least 3 char' )
    bootstrapValidate(['[name="phone"]'],'phone: enter valid phone')
    bootstrapValidate(['[name="email"]'],'email: enter valid mail')
    bootstrapValidate(['[name="state"]','[name="address"]'],'regex:^[a-zA-Z0-9 ]+$: enter valid address/state')
    bootstrapValidate('[name="postal_code"]','regex:^\\d{5}(-{0,1}\\d{4})?$: enter valid postal code')
    bootstrapValidate('[name="card_holder_name"]','regex:^[a-zA-Z0-9 ]+$: enter valid Credit card name')
    bootstrapValidate('[name="card_number"]','regex:^6(?:011\d{12}|5\d{14}|4[4-9]\d{13}|22(?:1(?:2[6-9]|[3-9]\d)|[2-8]\d{2}|9(?:[01]\d|2[0-5]))\d{10})$: enter valid credit card number')
    bootstrapValidate('[name="cvv"]','regex:^[0-9]{3,4}$: enter valid Card CVV')

    // $('#payInDelvired').click(function (evt) {
    //     evt.preventDefault();
    //     console.log('you are in payInDelvired')
    //     $('#dataToSaveOrderBefore').submit(function(event){
    //         console.log('successes dataToSaveOrderBefore>>>>>>')
    //         event.preventDefault();
    //     });
    // });

    // first_nameInput = document.querySelector('[name="first_name"]')
    // last_nameInput = document.querySelector('[name="last_name"]')
    // phoneInput = document.querySelector('[name="phone"]')
    // stateInput = document.querySelector('[name="state"]')
    // addressInput = document.querySelector('[name="address"]')
    // postal_codeInput = document.querySelector('[name="postal_code"]')
    // card_holder_nameInput = document.querySelector('[name="card_holder_name"]')
    // cvvInput = document.querySelector('[name="cvv"]')
    // function validateForms() {
    //     return [
    //         // first_nameInput,
    //         last_nameInput,
    //         phoneInput,
    //         stateInput,
    //         addressInput,
    //         postal_codeInput,
    //         card_holder_nameInput,
    //         cvvInput,
    //     ].every(validateInput)
    // }
    // function validateInput(input){
    //     return (
    //         input.value.length && input.value.length > 0
    //     );
    // }

    
</script>
<script type='text/javascript'>
        jQuery(document).ready(function(){
            jQuery('#rev_slider_4').show().revolution({
                dottedOverlay: 'none',
                delay: 5000,
                startwidth: 865,
	            startheight: 450,

                hideThumbs: 200,
                thumbWidth: 200,
                thumbHeight: 50,
                thumbAmount: 2,

                navigationType: 'thumb',
                navigationArrows: 'solo',
                navigationStyle: 'round',

                touchenabled: 'on',
                onHoverStop: 'on',
                
                swipe_velocity: 0.7,
                swipe_min_touches: 1,
                swipe_max_touches: 1,
                drag_block_vertical: false,
            
                spinner: 'spinner0',
                keyboardNavigation: 'off',

                navigationHAlign: 'center',
                navigationVAlign: 'bottom',
                navigationHOffset: 0,
                navigationVOffset: 20,

                soloArrowLeftHalign: 'left',
                soloArrowLeftValign: 'center',
                soloArrowLeftHOffset: 20,
                soloArrowLeftVOffset: 0,

                soloArrowRightHalign: 'right',
                soloArrowRightValign: 'center',
                soloArrowRightHOffset: 20,
                soloArrowRightVOffset: 0,

                shadow: 0,
                fullWidth: 'on',
                fullScreen: 'off',

                stopLoop: 'off',
                stopAfterLoops: -1,
                stopAtSlide: -1,

                shuffle: 'off',

                autoHeight: 'off',
                forceFullWidth: 'on',
                fullScreenAlignForce: 'off',
                minFullScreenHeight: 0,
                hideNavDelayOnMobile: 1500,
            
                hideThumbsOnMobile: 'off',
                hideBulletsOnMobile: 'off',
                hideArrowsOnMobile: 'off',
                hideThumbsUnderResolution: 0,
					

                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                startWithSlide: 0,
                fullScreenOffsetContainer: ''
            });
        });
</script>

<script>
//     $(document).on('click', '.add_to_wishlist', function(e) {

//     if ($(this).find('.ti-heart').hasClass('cartActive')) {
//         $(this).find('.ti-heart').removeClass("cartActive");
//         $(this).find('.ti-heart').attr("title","Add To WishList");
//         removeFromWishlist(e.target.getAttribute('productId'))
//         var msg = 'Item Successfully removed from wishlist';
//     } else {
//         $(this).find('.ti-heart').addClass("cartActive");
//         $(this).find('.ti-heart').attr("title","Remove From WishList");
//         // $(this).addClass("cartActive");

//         console.log('productId >>>', e.target.getAttribute('productId'))
//         addToWishlist(e.target.getAttribute('productId'))
//         var msg = 'Item Successfully added in wishlist';
//     }
//     $.notify({
//         icon: 'fa fa-check',
//         title: 'Success!',
//         message: msg
//     }, {
//         element: 'body',
//         position: null,
//         type: "info",
//         allow_dismiss: true,
//         newest_on_top: false,
//         showProgressbar: true,
//         placement: {
//             from: "top",
//             align: "right"
//         },
//         offset: 20,
//         spacing: 10,
//         z_index: 1031,
//         delay: 5000,
//         animate: {
//             enter: 'animated fadeInDown',
//             exit: 'animated fadeOutUp'
//         },
//         icon_type: 'class',
//         template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
//             '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
//             '<span data-notify="icon"></span> ' +
//             '<span data-notify="title">{1}</span> ' +
//             '<span data-notify="message">{2}</span>' +
//             '</div>'
//     });

// });

// function addToWishlist(id) {
//     $.get('/wishlist/store?id=' + id, function(response) {
//         console.log("success>in>blade>response>", response)
//         if (response["status"] === true) {
//             updateWishlistNumber()
//         }
//     });
// }

// function updateWishlistNumber() {
//     $.get('/wishlist/get', function(response) {
//         console.log("response >>>>>", response.wishlistProducts.length)
//         document.querySelector(".layout-header2 .wishlist-product").textContent = response.wishlistProducts.length
//     })
// }

// function removeFromWishlist(id) {
//     $.get('/wishlist/delete?id=' + id, function(response) {
//         console.log("success>in>blade>response>", response)
//         if (response["status"] === "success") {
//             updateWishlistNumber()
//         }
//     });
// }

// //Add To Cart

// $(document).on('click', '.addToCartFromCardComponent', function() {
//         $(this).addClass("cartActive");
//     });
//     $('.ti-bag').on('click', function() {
//         $(this).parent('.addToCartFromCardComponent').addClass("cartActive");
//     });


// $(document).on('click', '.product-box button .ti-bag,#quick-view .product-buttons .addToCart ,#singlePageProduct .product-buttons .addToCart ,.addToCartFromCardComponent', function(e) {
//         // e.stopImmediatePropagation;
//         e.stopPropagation()
//         let target = e.target.parentElement.parentElement

//         // let color= target.querySelector('.color-variant .active').className.split(' ').filter( cls => cls !=='active' )[0]
//         let color = (function() {
//                 try {
//                     return target.querySelector('.color-variant .active').getAttribute("type")
//                 } catch {
//                     return 'red';
//                 }
//             })()
//             // let attribut = '' || target.querySelector('.size-box ul .active a').innerHTML
//         let attribut = (function() {
//             try {
//                 return target.querySelector('.size-box ul .active a').innerHTML;
//             } catch {
//                 return 's';
//             }
//         })()

//         // let qty = target.querySelector('.qty-box [name="quantity"]').value
//         let qty = (function() {
//             try {
//                 return target.querySelector('.qty-box [name="quantity"]').value;
//             } catch {
//                 return 1;
//             }
//         })()
//         console.log("(e.target.getAttribute('productId') , [color,attribut].join() , qty", e.target.getAttribute('productId'), [color, attribut].join(), qty);

//         addToCart(e.target.getAttribute('productId'), [color, attribut].join(), qty);
//         $.notify({
//             icon: 'fa fa-check',
//             title: 'Success!',
//             message: 'Item Successfully added to your cart'
//         }, {
//             element: 'body',
//             position: null,
//             type: "success",
//             allow_dismiss: true,
//             newest_on_top: false,
//             showProgressbar: true,
//             placement: {
//                 from: "top",
//                 align: "right"
//             },
//             offset: 20,
//             spacing: 10,
//             z_index: 1101,
//             delay: 200,
//             animate: {
//                 enter: 'animated fadeInDown',
//                 exit: 'animated fadeOutUp'
//             },
//             icon_type: 'class',
//             template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
//                 '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
//                 '<span data-notify="icon"></span> ' +
//                 '<span data-notify="title">{1}</span> ' +
//                 '<span data-notify="message">{2}</span>' +
//                 '</div>'
//         });

//     });

//     function addToCart(id, attr, qty) {
//         console.log(qty);
//         console.log('attr',attr);
//         let attrbuite = attr === ',' ? '' : attr
//         $.get(`/cart/store?id=${id}&attribute=${attrbuite}&quantity=${qty}`, function(response) {
//             console.log("success>in>blade>response>", response)
//             if (response["status"] === "success") {
//                 updateCartNumber()
//             }
//         });
//     }

//     function updateCartNumber() {
//         $.get('/cart/get', function(response) {
//             // console.log( "response >>>>>", response.cartProducts.length)
//             console.log("response >>>>>", response.cartProducts)
//             var counter = 0;
//             for (var i = 0; i < response.cartProducts.length; i++) {
//                 counter += parseInt(response.cartProducts[i].quantity);
//             }
//             document.querySelector(".layout-header2 .cart-product").textContent = counter;
//             document.querySelector(".cart-link .cart-product").textContent = '( ' + counter + ' )';
//             // document.querySelector(".layout-header2 .cart-product").textContent = response.cartProducts.length;
//         })
//     }


//     //Cart
//     function getCart() {
//     $.get('/cart/get', function(response) {
//         // alert("success");
//         console.log("cart_side", response)

//         $.each(response.cartProducts, function(i, val) {
//             var pname = val.name;
//             $(".add_to_cart #cartlist_items").append(`

//             <div class="col-md-2 col-sm-6 col-xs-6">
//                 <div class="card" style="border: 1px solid #b22827;;padding: 5px;">
//                     <img class="card-img-top" style="width: 200px;height: 80px;display: block;margin-left: auto;margin-right: auto;" src="${val.thumbnail}" alt="${pname.substr(0,20)}">
//                     <div class="card-body">
//                     <p class="card-text">${pname.substr(0,20)}</p><p>$ ${val.price} : x ${val.quantity}</p>
//                     <hr>
//                     <div class="close-circle" style="text-align: center;"><i class="ti-trash" style="text-align: center;padding: 5px;color: #b22827;font-size: 20px;cursor: pointer;" productId="${val.id}" aria-hidden="true"></i></div>
//                     </div>
//                 </div>
//             </div>
            
            
                    
                   
//             `);
//         });

//         $(".add_to_cart #cartlist_total").append(`
//             <li>
//                 <div class="total" dir="ltr">
//                     <h5>subtotal : <span class="cart-totalPrice">$${response.totalPrice}</span></h5>
//                 </div>
//             </li>
//             <li>
//                 <div class="buttons">
//                     <a href="/cart" class="btn btn-normal btn-xs view-cart">view cart</a>
//                     <a href="/checkout" class="btn btn-normal btn-xs checkout">checkout</a>
//                 </div>
//             </li>
//         `);

//     });
// }

// function openCart() {
//     document.getElementById("cart_side").classList.add('open-side');
//     getCart();
// }

// function closeCart() {
//     document.getElementById("cart_side").classList.remove('open-side');
//     $("#cart_side ul.cart_product").html('')
//     $("#cart_side ul.cart_total").html('')
// }

// $("#cartModal").on('hide.bs.modal', function(){
//     closeCart();
// });

// $('#cart_side ul.cart_product').click(function(e) {
//         // console.log('productId >>>', e.target.getAttribute('productId') )
//         // console.log('ul.cart_product >>>', e.target )
//         if (e.target.hasAttribute('productId')) {
//             if (e.target.parentElement.classList.contains('close-circle')) {
//                 console.log('removed')
//                 e.target.parentElement.parentElement.remove()
//                 removeFromCart(e.target.getAttribute('productId'))
//             }
//         }
//     });

//     function removeFromCart(id) {
//         $.get('/cart/delete?id=' + id, function(response) {
//             console.log("success>in>blade>response>", response)
//             if (response["status"] === "success") {
//                 $(".add_to_cart #cartlist_total").html('');
//                 $(".add_to_cart #cartlist_items").html('');

//                 getCart();
//                 updateCartNumber();
//             }
//         });
//     }
</script>

<!-- <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script> -->
        @yield('javascript')