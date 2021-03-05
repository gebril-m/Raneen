$(document).ready(function(){
    $(document).on('click','#payfort_fort_pay_action',function (evt) {

         evt.preventDefault();

        console.log($('input[name="radio1"]:checked').val());


        if ($('input[name="radio1"]:checked').val()==="credit"){
            if (validateForm() === false){
                $('input[name="card_holder_name"]').focus();
                alert(" برجاء ملئ الحقول والتأكد من أرقام البطاقة");
                return;
            }
            else {
                alert('هذه الخدمة غير متوفرة حاليا ')
                // let datapayfort = {};
                // let paramsString = $("#dataToSaveOrderBefore").serialize();
                // let mySearchParams = new URLSearchParams(paramsString);
                // for (const [key, value] of mySearchParams) {
                //     datapayfort[key]=value
                // };
                //
                //
                //
                // $.post( "/payfortSaveOrder" ,  datapayfort , function( data ) {
                //     console.log( data ); // John
                // }, "json").done(function( response ) {
                //
                //     var $form = $('#payfort_fort_form');
                //     var form_elements = {};
                //     form_elements = $form.find('input:hidden').serialize();
                //
                //     $.ajax({
                //         type: 'post',
                //         dataType: 'json',
                //         url: "http://127.0.0.1:8000/payfortToken",
                //         data: form_elements,
                //         success: function (response) {
                //             console.log(response);
                //             if (response.form) {
                //                 $('body').append(response.form);
                //                 var expDate = $('#payfort_fort_expiry_year').val() + '' + $('#payfort_fort_expiry_month').val();
                //                 var mp2_params = {};
                //                 mp2_params.card_holder_name = $('#payfort_fort_card_holder_name').val();
                //                 mp2_params.card_number = $('#payfort_fort_card_number').val();
                //                 mp2_params.expiry_date = expDate;
                //                 mp2_params.card_security_code = $('#payfort_fort_cvv').val();
                //                 $.each(mp2_params, function (k, v) {
                //                     console.log(k +' - '+ v);
                //                     $('<input>').attr({
                //                         type: 'hidden',
                //                         id: k,
                //                         name: k,
                //                         value: v
                //                     }).appendTo('#payfort_final_payment_form');
                //                 });
                //                 //$('#payfort_final_payment_form input[type=submit]').click();
                //
                //             } else {
                //                 console.log('Unable to contact server for payment processing');
                //             }
                //         },
                //         error: function (jqXHR, textStatus, errorThrown) {
                //             console.log(errorThrown);
                //         }
                //     });
                //
                // })

            }
        }
        else {

        }

    })

    $('select[name="country_idx"]').change(function(){
        var country_id = $(this).val();
        $.get('/get_cities/'+country_id,function(res){
            if(res){
                res.forEach(function(item){
                    $('#city_select').empty();
                    $('#city_select').append(`<option value="${item.id}">${item.name}</option>`);
                })
            }else{
                $('#city_select').empty();
            }

        })
    })
    $('#country_id').on('change',function(){
        console.log("Changed");
        var country_id = $(this).val();
        $('#city_id option').each(function(index,val){
            if($(val).data('country') != country_id){
                $(val).hide();
            }else{
                $(val).show();
            }
        })
    })
    $('#city_id').on('change',function(){
        console.log("Changed");
        var city_id = $(this).val();
        $('#state_id option').each(function(index,val){
            console.log($(val))
            if($(val).data('city') != city_id){
                $(val).hide();
            }else{
                $(val).show();
            }
        })
    })
    $('input[name="radio1"]').change(function(){

            $('#payfort_fort_pay_action').fadeIn();

    })
    $('input[name="card_holder_name"]').change(function(){
        check_card_fields();
    })
    $('input[name="card_holder_name"]').keyup(function(){
        check_card_fields();
    })
    $('input[name="card_number"]').change(function(){
        check_card_fields();
    })
    $('input[name="card_number"]').keyup(function(){
        check_card_fields();
    })
    $('input[name="cvv"]').change(function(){
        check_card_fields();
    })
    $('input[name="cvv"]').keyup(function(){
        check_card_fields();
    })
    function check_card_fields(){
        var card_holder_name = $('input[name="card_holder_name"]');
        var card_number = $('input[name="card_number"]');
        var cvv = $('input[name="cvv"]');

        var val_card_holder_name = empty_input_validate(card_holder_name);
        var val_card_number = number_input_validate(card_number,16);
        var val_cvv = number_input_validate(cvv,3);
        if(
            val_card_holder_name === true &&
            val_card_number === true &&
            val_cvv === true
            ){
                $('#payfort_fort_pay_action').fadeIn();
            }
    }
    $('.next-step').click(function(){
        var current_step = $(this).data('step');
        var next_step = current_step+1;
        var self = $(this);
        if(current_step == 1){
            var first_name = $('input[name="first_name"]');
            var last_name = $('input[name="last_name"]');
            var phone = $('input[name="phone"]');
            var email = $('input[name="email"]');
            var address = $('input[name="address"]');
            var state = $('input[name="state"]');
            var postal_code = $('input[name="postal_code"]');
            var country_id = $('input[name="country_id"]');
            var city_id = $('input[name="city_id"]');

            var val_firstname = empty_input_validate(first_name);
            var val_last_name = empty_input_validate(last_name);
            var val_phone = number_input_validate(phone,11);
            var val_email = email_input_validate(email);
            var val_address = empty_input_validate(address);
            var val_state = empty_input_validate(state);
            var val_postal_code = empty_input_validate(postal_code);
            var val_country_id = empty_input_validate(country_id);
            var val_city_id = empty_input_validate(city_id);
            if(
                val_firstname === true &&
                val_last_name === true &&
                val_phone === true &&
                val_email === true &&
                val_address === true &&
                val_state === true &&
                val_postal_code === true &&
                val_country_id === true &&
                val_city_id === true
                ){
                    next_step_view(self,current_step,next_step);
                }
        }
        if(current_step == 2){
            next_step_view(self,current_step,next_step);
        }
        // if(current_step == 3){


        // }


    })
    function empty_input_validate(input){
        if(input.val() == ''){
            input.addClass('Wrong');
            return false;
        }else{
            input.removeClass('Wrong');
            return true;
        }
    }
    function email_input_validate(input){
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(input.val())) {
            input.addClass('Wrong');
            return false;
        }else{
            input.removeClass('Wrong');
            return true;
        }
    }
    function number_input_validate(input,lengthwanted){
        var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(input.val())) {
            if(input.val().length!=lengthwanted){
                input.addClass('Wrong');
                return false;
            }else{
                input.removeClass('Wrong');
                return true;
            }
        }else{
            input.addClass('Wrong');
            return false;
        }

    }
    function next_step_view(self, current_step, next_step){
        $('.back-step').show();
        if(current_step < 3){
            $('.steps').addClass('hide-step');
            $('.step'+next_step).removeClass('hide-step');
            self.data('step',next_step);
        }
        if(next_step == 3){
            // $('#payfort_fort_pay_action').fadeIn();
            self.hide();
        }
    }
    $('.back-step').click(function(){
        $('.steps').addClass('hide-step');
        $('.step1').removeClass('hide-step');
        $('#payfort_fort_pay_action').hide();
        $('.next-step').fadeIn();
        $('.next-step').data('step',1);
        $(this).hide();
    })
    $('.back-step').hide();

    function validateForm() {
        if ($('input[name="radio1"]:checked').val()==="credit"){
            var card_holder = $('input[name="card_holder_name"]');
            var card_number = $('input[name="card_number"]');
            var cvv = $('input[name="cvv"]');
            var expiry_year = $('input[name=" expiry_year"]');
            var expiry_month = $('input[name=" expiry_month"]');

            return card_holder.val() !== '' && card_number.val() !== '' && isNaN(card_number.val()) === false && cvv.val() !== '' && isNaN(cvv.val()) === false && expiry_year.val() !== '' && expiry_month.val() !== '';

        }

    }
})
