<?php

namespace App\Helpers\Payment;
use App\PayfortMerchant2;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Mockery\Exception;
use Input;
use Validator;
use Carbon\Carbon ;
use DB;
use Cookie ;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller ;
/**
* 
*/
class Payfort extends PayfortMerchant2
{
	function __construct()
	{
	    parent::__construct();
        $this->setMerchantIdentifier("2b371e07");
        $this->setMerchantAccessCode("hNuBzdiJ6hLi6Yls0VGj");
        $this->setSandboxMode( "true"); // set to false if this is in production
        $this->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $this->setResponsePhrase( "$2y$10$6UfHXoCqi"); //TESTSHAOUT
        $this->setRequestPhrase("$2y$10$70dwkpDI/"); //TESTSHAIN
    }

    public function token(){

        $url = '/payfortOperation';
        $exception =  ['card_holder_name','card_number','expiry_year','expiry_month','ccv'];
        foreach ($_REQUEST as $key => $value){
            if(!in_array($key,$exception)){
                unset($_REQUEST[$key]);
            }
        }
        $this->setReturnUrl(url($url));
        $this->setRememberToken(TRUE);

        $this->setMerchantReference($this->generateRandomString());
        echo $this->processRequest(array('paymentMethod'=>'cc_merchant_page_2'));

    }
    public function operation()
    {
        $successUrl = '/payfortFinish';
        $this->setDefaultCurrency('EGP');
        $this->setAmount('100');
        $this->setServiceCommand('PURCHASE');
        $this->setRememberToken(TRUE);
        $this->setReturnUrl(url($successUrl));
//        dd(\request()->all());
        if ((request()->get("response_message")!= "Success")) {
            $message = trans("errors.".\request()->get("response_message"));
            return Redirect::back()->withErrors($message);
        }

        $this->setCustomerData(1, $_REQUEST['card_holder_name'], "email");
        $arr = $this->processMerchantRequest($_REQUEST);
        if($arr['response']['params']['status'] == '20')
        {
            return redirect($arr['response']['params']['3ds_url']);
        }
        else
        {

            if($arr['response']['params']['status'] != '14000' )
            {
                $message = trans("words.booking error message") . PHP_EOL .$arr['response']['message'] ;
                return Redirect::back()->withErrors([$message, $message]);

            }
            else
            {
                return redirect($arr['response']['params']['3ds_url']);

            }
        }
//        return $arr;

    }
    public function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}


