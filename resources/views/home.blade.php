<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEST</title>
</head>
<body>
https://sbcheckout.payfort.com/FortAPI/paymentPage
https://sbcheckout.payfort.com/FortAPI/paymentApi/
{{--
<form method="post" action="http://localhost:8000/payfort/" id="form1" name="form1">
    {{csrf_field()}}
    <input type="hidden" name="action" value="generate_final_form">
    <input type="hidden" name="merchant_identifier" value="2b371e07">
    <input type="hidden" name="access_code" value="hNuBzdiJ6hLi6Yls0VGj">
    <input type="hidden" name="merchant_reference" value="SSvpsegNwD">
    <input type="hidden" name="language" value="en">
    <input type="hidden" name="service_command" value="TOKENIZATION">
    <input type="hidden" name="return_url" value="http://localhost:8000/paymentToken/">
    <input type="hidden" name="signature" value="6341837a8d6a194d2fb5b7fdec71853d8fe626eee229eacf64d2819f4b5427a1">
    <input type="hidden" name="expiry_date" value="2101">
    <input type="hidden" name="card_number" value="4005550000000001">
    <input type="hidden" name="card_security_code" value="123">
    <input type="hidden" name="card_holder_name" value="mohamed">
    <input type="submit" id="submit">
</form>
--}}
<form class="payment-form text-left"  id="payfort_fort_form" action="http://localhost:8000/payfortToken" method="post">

    <div class="form-group">
        <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_card_holder_name" >Name on Card</label>
        <div class="large-12 medium-12 small-12 column">
            <input type="text" class="form-control in-style" id="payfort_fort_card_holder_name" name="card_holder_name" value="" placeholder="Name on card" maxlength="50">
        </div>
    </div>
    <div class="form-group">
        <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_card_number">Card Number</label>
        <div class="large-12 medium-12 small-12 column">
            <input type="text" class="form-control in-style" id="payfort_fort_card_number" name="card_number" value="" placeholder="Credit card number" maxlength="16">
        </div>
    </div>
    <div class="form-group">
        <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_expiry_month">Expiration Date</label>
        <div class="">
            <div class="row">
                <div class="large-6 medium-6 small-6 column">
                    <select class="form-control in-style col-sm-2" name="expiry_month" id="payfort_fort_expiry_month">
                        <option value="01">Jan - 01</option>
                        <option value="02">Feb - 02</option>
                        <option value="03">Mar - 03</option>
                        <option value="04">Apr - 04</option>
                        <option value="05">May - 05</option>
                        <option value="06">June - 06</option>
                        <option value="07">July - 07</option>
                        <option value="08">Aug  - 08</option>
                        <option value="09">Sep - 09</option>
                        <option value="10">Oct - 10</option>
                        <option value="11">Nov - 11</option>
                        <option value="12">Dec - 12</option>
                    </select>
                </div>
                <div class="large-6 medium-6 small-6 column">
                    <select class="form-control in-style" name="expiry_year" id="payfort_fort_expiry_year">
                        <?php
                        $today = getdate();
                        $year_expire = array();
                        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
                            $year_expire[] = array(
                                'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
                                'value' => strftime('%y', mktime(0, 0, 0, 1, 1, $i))
                            );
                        }
                        ?>
                        <?php
                        foreach($year_expire  as $year) {
                            echo "<option value={$year['value']}>{$year['text']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="large-12 medium-12 small-12 column control-label" for="payfort_fort_mp2_cvv">Card CVV</label>
        <div class="large-7 medium-7 small-7 column">
            <input type="text" class="form-control in-style" name="cvv" id="payfort_fort_cvv" name="cvv" value="" placeholder="CVV" maxlength="4">
        </div>

        <div class="large-5 medium-5 small-5 column">
            <input type="submit" id="payfort_fort_pay_action">
        </div>

    </div>
</form>

<script src="{{asset('/assets/js/jquery-3.3.1.min.js')}}"></script>
<script>
    $('#payfort_fort_form').on('submit',function (evt) {
        var $form = $('#payfort_fort_form');
        var form_elements = {};
        form_elements = $form.find('input:hidden').serialize();
        console.log(form_elements);
        evt.preventDefault();
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: $form.attr('action'),
            data: form_elements,
            success: function (response) {
                if (response.form) {
                    $('body').append(response.form);
                    var expDate = $('#payfort_fort_expiry_year').val() + '' + $('#payfort_fort_expiry_month').val();
                    var mp2_params = {};
                    mp2_params.card_holder_name = $('#payfort_fort_card_holder_name').val();
                    mp2_params.card_number = $('#payfort_fort_card_number').val();
                    mp2_params.expiry_date = expDate;
                    mp2_params.card_security_code = $('#payfort_fort_cvv').val();
                    $.each(mp2_params, function (k, v) {
                        console.log(k +' - '+ v);
                        $('<input>').attr({
                            type: 'hidden',
                            id: k,
                            name: k,
                            value: v
                        }).appendTo('#payfort_final_payment_form');
                    });
                    $('#payfort_final_payment_form input[type=submit]').click();

                } else {
                    payfortFortMerchant.showError('Unable to contact server for payment processing');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                payfortFortMerchant.showError(errorThrown);
            }
        });
    });
</script>
{{--<script type="text/javascript" src="{{asset('js/checkout.js')}}"></script>--}}

</body>
</html>