$(document).ready(function(){
    $('.products-grid').infiniteScroll({
      // options
      path: '.page-link[rel="next"]',
      append: '.products-grid',
      history: false,
    });

    $('.sortProduct').change(function(){
        $('#sort_form').submit();
    })

    let brands = [];
    let attrs = [];
    $('input[name="brands_change"]').on('keyup change',function(){
        filter_now($(this));
    })
    $('input[name="attrs_change"]').on('keyup change',function(){
        filter_now($(this));
    })
    $('input[name="min-price"]').on('keyup change',function(){
        filter_now($(this));
    })
    $('input[name="max-price"]').on('keyup change',function(){
        filter_now($(this));
    })
    function filter_now(self){
        $('.filter-none').remove();
        var prices = $('input[name="min-price"]').val()+','+$('input[name="max-price"]').val();
        if(self.parents('ul').attr('class') == 'brands'){
            if(self.is(':checked') === true){
                if($.inArray(self.val(),brands) == -1){
                    brands.push(self.val());
                }
            }else{
                if($.inArray(self.val(),brands) != -1){
                    brands.splice($.inArray(self.val(),brands),1);
                }
            }
        }
        if(self.parents('ul').attr('class') == 'attrs'){
            if(self.is(':checked') === true){
                if($.inArray(self.val(),attrs) == -1){
                    attrs.push(self.val());
                }
            }else{
                if($.inArray(self.val(),attrs) != -1){
                    attrs.splice($.inArray(self.val(),attrs),1);
                }
            }
        }
        console.log("brands",brands);
        console.log("attrs",attrs);
        var search_text=$('input[name="search_text"]').val();
        
        $('input[name="brands_filter"]').val(brands);
        var url = '';
        if($('input[name="category_id"]').length != 0){
            url = '/category_filter/'+$('input[name="category_id"]').val()+'?brands='+brands+'&prices='+prices+'&attrs='+attrs;
            $('.product-grid-area').load(url);
            console.log("Category search..."+url);
        }else if(search_text != null){
            url = '/search_filter/'+$('input[name="search_text"]').val()+'?brands='+brands+'&prices='+prices+'&attrs='+attrs;
            $('.product-grid-area').load(url);
            console.log("search input ..."+url);
        }else{
            url = '/search_filter/0'+$('input[name="search_text"]').val()+'?specials=on_sale,up_selling&cat=all&prices='+prices
            $('.product-grid-area').load(url);
            console.log("no search input..."+url);
        }
    }
})