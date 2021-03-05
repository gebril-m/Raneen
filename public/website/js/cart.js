$(document).ready(function(){
    $('.attribute-btn').on('click',function(){
        var self = $(this);
        self.parent('.attributes-btns').find('.attribute-btn').removeClass('active');
        self.addClass('active');
    })
    $('.increase-btn').click(function(){ 
        var qty = $(this).parents('.quantity_cart').find('input');
        $(this).parents('.quantity_cart').find('input').val(Number(qty.val())+1);
        qty.trigger('change');
    })
    $('.decrease-btn').click(function(){
        var qty = $(this).parents('.quantity_cart').find('input');
        $(this).parents('.quantity_cart').find('input').val(Number(qty.val())-1);
        qty.trigger('change');
    })
    $('.qtybutton2').click(function(){
        $(this).parent('.quantity_cart').find('input').trigger('change');
    })
    $('input[name="qty"]').on('keyup change', function(){
        var self = $(this);
        numberInput(self);
    })
    $('.qty-update').on('keyup change', function(){
        var self = $(this);
        numberInput(self);
    })
    function numberInput(str){
        if((isNaN(str.val())) || (str.val() <= 0) ){
            str.val('1');
        }
    }
    $('.subscribe-now').click(function(e) {
        e.preventDefault(); 
        let demo= window.location.origin;
        var url = demo+'/subscribe/' + $('input[name="email-subscribe"]').val();
        console.log(demo);
        $.get(url, function(res) {
            //Error
            if (res.status == 'error') {
                $('.request-msg').html('<div class="alert alert-danger">'+ res.message +'</div>');
            }
            //Success
            if (res.status == 'success') {
                $('.request-msg').html('<div class="alert alert-success">'+ res.message +'</div>');
            }
        })
    })

    // Open Cart Function (Sherif)
    new website_getCart();

    // Update Qty
    $('.qty-update').keyup(function(){
        var productId = $(this).attr('productId');
        var qty = $(this).val();
        var price = $(this).parents('tr').find('.price_total span').html();
        var new_total = parseInt($(this).parents('tr').find('.price span').html()) * parseInt(qty);
        $(this).parents('tr').find('.price_total span').html(new_total);
        website_addtocart(productId,'',qty,'','update');
        update_total();
    })
    $('.qty-update').change(function(){
        var productId = $(this).attr('productId');
        var qty = $(this).val();
        var price = $(this).parents('tr').find('.price_total span').html();
        var new_total = parseInt($(this).parents('tr').find('.price span').html()) * parseInt(qty);
        $(this).parents('tr').find('.price_total span').html(new_total);
        website_addtocart(productId,'',qty,'','update');
        update_total();
    })

    // Add to Cart Function (Sherif)
    $(document).on('click','.combo_add_cart',function(){
        var combo = $(this).data('combo');
        $('.product-variation .website_addtocart').trigger('click');
        setTimeout(function(){
            $('.combo_inputs:checked').each(function(index,item){
                setTimeout(function(){
                    var qty = 1;
                    var attr = '';
                    var id = $(item).attr('productid');
                    var price = $(item).data('price');
                    var discount = $(item).data('discount');
                    var price_after = $(item).data('priceafter');
                    console.log("Starting add to cart combo for product "+id);
                    new website_addtocart(id,attr,qty,$(this),'combo',price,discount,price_after,combo);
                },2000)
            })
        },1000);
    })
    $(document).on('click','.website_addtocart',function(){
        var qty = $('input[name="qty"]');
        var price = $(this).attr('price');
        //console.log(price);
        var combo = $(this).data('combo');
        var attr = [];
        $('.attribute-btn').each(function(index,item){
            var self = $(this);
            if(self.hasClass('active')){
                attr.push(self.data('id'));
            }
        })
        if(attr.length == 0){
            attr = '';
        }
        var id = $(this).attr('productId');
        if(qty.length < 1){
            qty = $(this).attr('qty');
        }else{
            qty = qty.val();
        }

        var id = $(this).attr('productid');
        var price = $(this).attr('price');
        var discount = $(this).attr('discount');
        var price_after = $(this).attr('priceafter');
        if(combo > 0){
            var qty = 1;
            var attr = '';
            
            new website_addtocart(id,attr,qty,$(this),'combo',price,discount,price_after,combo);
        }else{
            new website_addtocart(id,attr,qty,$(this),'false',price,discount,price_after);
        }
    })
    function update_total(){
        var total = 0;
        $('.price_total span').each(function(index,value){
            total = parseInt(total) + parseInt($(this).html());
        })
         $('.total_price_cart').html(total);
    }
    function website_addtocart(id,attr,qty,self,type,price,discount,price_after,combo_id){
        //let demo= window.location.origin;
        //var url = demo+'/cart/store?id='+id+'&attribute='+attr+'&quantity='+qty+'&type='+type+'&price='+price+'&discount='+discount+'&price_after='+price_after+'&combo_id='+combo_id;
        var url = '/cart/store?id='+id+'&attribute='+attr+'&quantity='+qty+'&type='+type+'&price='+price+'&discount='+discount+'&price_after='+price_after+'&combo_id='+combo_id;
        
        $.ajax({
                    
                    url: url,
                    type: 'get',
                    beforeSend: function(){
                        self.addClass('buttonload');
                        self.html('<i class="fa fa-spinner fa-spin"></i> . جاري الاضافه للسله') 
                    },
                    // success
                    success: function(res){
                            if (res["status"] === "success"){  
                               new website_updatecart();
                               self.parents('tr').find('.removeWishlist').trigger('click');
                               new alert_message('success',res.msg);
                            }
                            if (res["status"] === "combo_not_found"){
                                new alert_message('error','Combo Main Product not Added To Cart');
                             }
                             if (res["status"] === "issue"){
                                 new alert_message('error','issue in backend');
                              }
                            
                            if (res["status"] === "fail"){
                               new alert_message('error','Item is out of stock');
                            }
                            self.removeClass('buttonload');
                            self.html('<i></i>اضف الي عربة التسوق')
                        }
                });
        
        // $.get(url,function(res){
        //    // console.log(res["status"]);
        //     //console.log(res);
             
        // })
    }
    function website_updatecart(){
        $.get('/cart/get', function(response) {            
            var counter = 0;
            for (var i = 0; i < response.cartProducts.length; i++) {
                counter += parseInt(response.cartProducts[i].quantity);
            }
            if(counter == 0){
                $('.website_cart_counter').hide();
            }else{
                $('.website_cart_counter').show();
                $('.website_cart_counter').text(counter);
            }
            //new alert_message('success','Item Successfully added to your cart');
            new website_getCart();
        })
    }


    // Cart View (Sherif)
    $(document).on('hover','.open-drop-cart',function(){
       new website_getCart();
    })
    function website_getCart(){
        $('#cart-sidebar').empty();
        $.get('/cart/get', function(response) {
        $.each(response.cartProducts, function(i, val) {
            //console.log(val.price);
            var pname = val.name;
            var price=val.price;
            var currency=$('#header_currency').val();
            var qty=$('#header_qty').val();
            // if (typeof val.discount !== 'undefined') {
            //     var discount = val.discount;
            //     var price=val.price-discount;
            // }
            $('#cart-sidebar').append(`
                <li class="item odd">
                    <a href="/cart" title="${pname.substr(0,20)}" class="product-image"><img src="${val.thumbnail}" alt="${pname.substr(0,20)}" width="65"></a>
                    <div class="product-details"> <a href="#" title="Remove This Item" class="remove-cart" productId="${val.id}"><i class="pe-7s-trash"></i></a>
                        <p class="product-name"><a href="/cart">${pname.substr(0,20)}</a> </p>
                        <strong>  <p class="product-name"> ${price} ${currency}</p> 
                        <p class="product-name">${qty}: ${val.quantity}</p></strong>   </div>
                </li>
                `);
        });
        $('.top-subtotal span').text(response.totalPrice);

    });
    }
    $(document).on('click','.ti-trash, .removeProduct, .remove-cart',function(){
        var id = $(this).attr('productId');
        new removeFromCart(id);
    })
    function removeFromCart(id) {
        $.get('/cart/delete?id=' + id, function(response) {
            console.log(response)
            if (response["status"] === "success") {
                $(".add_to_cart #cartlist_total").html('');
                $(".add_to_cart #cartlist_items").html('');
                website_getCart();
                website_updatecart();
                removeCartLine(id);
            }
        });
    }
    function removeCartLine(id){
        $('.cart-line-'+id).hide();
        var total = $('.cart-line-'+id).find('.price_total span').html();
        var total_before = $('.total_price_cart').html();
        var total_after = total_before-total;
        $('.total_price_cart').html(total_after);
    }

    function closeCart() {
        document.getElementById("cart_side").classList.remove('open-side');
        $("#cart_side ul.cart_product").html('')
        $("#cart_side ul.cart_total").html('')
    }

    $("#cartModal").on('hide.bs.modal', function(){
        closeCart();
    });

    // Alert Message Function (Sherif)
    function alert_message(type,message){
        // $.notify(message,type);
        var CartURL=document.getElementById('cart_url').value;
        if(type == 'error'){
            var HtmlText=' ';
        }else{
            var HtmlText='<a class="site-button" href="'+CartURL+'">الذهاب للسلة<img src=""></a>';
        }
        Swal.fire({
            title: message,
            html: HtmlText,
            type: type,
            showCancelButton: false,
            confirmButtonColor: 'red',
            confirmButtonText: 'متابعة التسوق'
        });
        //$.notify(message, {type:type,close: true});
        // $.notify({
  //           icon: 'fa fa-check',
  //           title: type+'!',
  //           message: message
  //       }, {
  //           element: 'body',
  //           position: null,
  //           type: type,
  //           allow_dismiss: true,
  //           newest_on_top: false,
  //           showProgressbar: true,
  //           placement: {
  //               from: "top",
  //               align: "right"
  //           },
  //           offset: 20,
  //           spacing: 10,
  //           z_index: 1101,
  //           delay: 200,
  //           animate: {
  //               enter: 'animated fadeInDown',
  //               exit: 'animated fadeOutUp'
  //           },
  //           icon_type: 'class',
  //           template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
  //               '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
  //               '<span data-notify="icon"></span> ' +
  //               '<span data-notify="title">{1}</span> ' +
  //               '<span data-notify="message">{2}</span>' +
  //               '</div>'
  //       });
    }
})