$(document).ready(function(){
	$(document).on('click','.add_to_compare',function(){
        $('.compare_counter').show();
        var product = $(this).data('productid');
		$.get('/add_to_compare/'+product,function(res){
            console.log(res);
			if(res == "added"){
                alert_message("success","Added to Compare");
                $('.compare_counter').text(Number($('.compare_counter').text())+1);
			}
			if(res == "exist"){
				alert_message("danger","Already in the list");
			}
			if(res == "Not the same category"){
				alert_message("danger","Not The Same Category");
			}
			if(res == "limit"){
				alert_message("danger","Compare list is full");
			}
		})	
	})
    $(document).on('click','.remove-compare',function(){
        var product = $(this).data('productid');
        var self = $(this);
        $.get('/remove_from_compare/'+product,function(res){
            if(res == "true"){
                self.parents('li').hide();
                
                $('.compare_counter').text(Number($('.compare_counter').text())-1);
                if(Number($('.compare_counter').text()) == 0){
                    $('.compare_counter').hide();
                }else{
                    $('.compare_counter').show();
                }
            }
        })
    })
	// Alert Message Function (Sherif)
	function alert_message(type,message){
        $.notify(message,type);
		// $.notify({
        //     icon: 'fa fa-check',
        //     title: type+'!',
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