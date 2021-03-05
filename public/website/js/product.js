$(document).ready(function(){

    
    $('.attribute-btn').click(function(){
        new calculate_attrs();
    })
    new calculate_attrs();
    function calculate_attrs(){
        console.log("Start Calculating Attributes ....");
        let attrs_price = 0;
        let image_path = "";
        $('.attribute-btn.active').each(function(index,item){
            attrs_price += $(item).data('price');
            if((image_path == "") && ($(item).data('picture') != "")){
                image_path = $(item).data('picture');
                $('.large-image a').attr('href',image_path);
                $('.large-image .zoom-img').attr('src',image_path);
            }
        })
        $total = Number($('input[name="original_price"]').val())+Number(attrs_price);
        $('.special-price .price span').text($total);
        $('input[name="price"]').val($total);
    }
    $('.combo_inputs').change(function(){
        new calculate_combo();
    })
    function calculate_combo(){
        $('.bundle-price').show();
        $('.bundle-price .before').show();
        $('.bundle-price .after').show();
        var product_ids = [];
        var combo_id = $('.website_addtocart').data('combo');
        var main_price = Number($('.special-price .price span').text());
        $('.combo_inputs:checked').each(function(index,item){
            main_price += $(item).data('price');
            product_ids.push($(item).attr('productid'));
        })
        product_ids.push($('.website_addtocart').attr('productid'));
        $.get('/check_combo_price/'+product_ids+'/'+combo_id,function(res){
            console.log(res);
            $('.bundle-price .after').text('$'+res[1]);
        })
        $('.bundle-price .before').text('$'+main_price);
        
    }

    function agree_terms()
    {
        $('#agree_terms_modale').show();
        // $.get('/get-agree-terms/',function(data){
        //     Swal.fire({
        //         title:'okokk',
        //         html: data,
        //         showCancelButton: false,
            
        //     });
        // })
    }
})