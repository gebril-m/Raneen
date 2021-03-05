$(document).ready(function() {

    // Wishlist Function (Sherif)
    $(document).on('click', '.add_to_wishlist', function(e) {
        var id = $(this).find('.ti-heart').attr('productId');
        if (id == '') {
            id = $('#productId').attr('productId');
        } else {
            id = id;
        }
        if ($(this).find('.ti-heart').hasClass('cartActive')) {
            $(this).find('.ti-heart').removeClass("cartActive");
            $(this).find('.ti-heart').attr("title", "Add To WishList");
            removeFromWishlist(id)
            var msg = 'تم إزالة المنتج من المفضله';
        } else {
            $(this).find('.ti-heart').addClass("cartActive");
            $(this).find('.ti-heart').attr("title", "Remove From WishList");
            // $(this).addClass("cartActive");
	        addToWishlist(id)
	        var msg = 'تم إضافة المنتج الي المفضله';
	    }
    	new alert_message('success',msg)
	});
	$(document).on('click','.removeWishlist',function(){
		var id = $(this).attr('productId');
		removeFromWishlist(id,$(this).parent('tr'));
	})
	function addToWishlist(id) {
	    $.get('/wishlist/store?id=' + id, function(response) {
	        console.log("success>in>blade>response>", response)
	        if (response["status"] === true) {
	            updateWishlistNumber()
            }
            if (response["status"] === true) {
                updateWishlistNumber()
            }
	    });
	}

    // function addToWishlist(id) {
    //     $.get('/wishlist/store?id=' + id, function(response) {
    //         console.log("success>in>blade>response>", response)
    //         if (response["status"] === true) {
    //             updateWishlistNumber()
    //         }
    //     });
    // }

    function updateWishlistNumber() {
        $.get('/wishlist/get', function(response) {
            console.log("response >>>>>", response.wishlistProducts.length)
            
            $('.wishlist-product').text(response.wishlistProducts.length)
            if(response.wishlistProducts.length == 0){
                $('.wishlist-product').hide();
            }else{
                $('.wishlist-product').show();
            }
            document.querySelector(".layout-header2 .wishlist-product").textContent = response.wishlistProducts.length
        })
    }


    function removeFromWishlist(id,tr) {
        console.log($(this).text);
        $.get('/wishlist/delete?id=' + id, function(response) {
            console.log("success>in>blade>response>", response)
            if (response["status"] === "success") {
                updateWishlistNumber()
                if(tr){
                    tr.hide();
                }
            }
        });
    }


    // Alert Message Function (Sherif)
    function alert_message(type, message) {
        Swal.fire({
            title: message,
    
            type: type,
            showCancelButton: false,
            confirmButtonColor: 'red',
            confirmButtonText: 'متابعة التسوق'
        });
        // $.notify(message,type); 
        // $.notify({
        //     icon: 'fa fa-check',
        //     title: type + '!',
        //     message: message
        // }, {
        //     element: 'body',
        //     position: null,
        //     type: type,
        //     allow_dismiss: true,
        //     newest_on_top: false,
        //     showProgressbar: true,
        //     placement: {
        //         from: "top",
        //         align: "right"
        //     },
        //     offset: 20,
        //     spacing: 10,
        //     z_index: 1101,
        //     delay: 200,
        //     animate: {
        //         enter: 'animated fadeInDown',
        //         exit: 'animated fadeOutUp'
        //     },
        //     icon_type: 'class',
        //     template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        //         '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        //         '<span data-notify="icon"></span> ' +
        //         '<span data-notify="title">{1}</span> ' +
        //         '<span data-notify="message">{2}</span>' +
        //         '</div>'
        // });
    }
})