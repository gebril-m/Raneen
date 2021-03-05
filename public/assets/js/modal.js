(function($) {
    "use strict";
    $(window).on('load', function() {
        $('#exampleModal').modal('show');
    });

    $(document).on('click', '.quick-view-btn', function() {
        var prodDesc = $(this).data('description');
        var rating = $(this).data('reviews'); 
        var reviews = "";
        if(rating==0){
            reviews = `<i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>`;
        }
        if(rating==1){
            reviews = `<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>`;
        }
        if(rating==2){
            reviews = `<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>`;
        }
        if(rating==3){
            reviews = `<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>`;
        }
        if(rating==4){
            reviews = `<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>`;
        }
        if(rating==5){
            reviews = `<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>`;
        }
        $('#quick-view').find('[data-type="name"]').html($(this).data('name'))
        $('#quick-view').find('[data-type="price"]').html($(this).data('price'))
        $('#quick-view').find('[data-type="before_price"]').html($(this).data('before_price'))
        $('#quick-view').find('[data-type="stock_status"]').html($(this).data('stock_status'))
        $('#quick-view').find('.product-right_price').attr('value', $(this).data('price'))
        $('#quick-view').find('.quick-view-url').attr('href', $(this).data('url'))
        $('#quick-view').find('.quick-view-img img').attr("src", $(this).data('image'))
        $('#quick-view').find('.qty-box .input-number').val("1")
        $('#quick-view').find('[data-type="description"]').html(prodDesc.substr(0, 1000))
        $('#quick-view').find('#productId').attr("productId", $(this).data('id'))
        $('#quick-view').find('.view-btn-details').attr("href", $(this).data('url'))
        $('#quick-view').find('.rating').html(reviews)
        $('#quick-view').modal('show');

        return false;
    });

    function openSearch() {
        document.getElementById("search-overlay").style.display = "block";
    }

    function closeSearch() {
        document.getElementById("search-overlay").style.display = "none";
    }

})(jQuery);

function dismiss() {
    document.getElementById('dismiss').style.display = 'none';
};