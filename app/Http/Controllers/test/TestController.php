<?php

namespace App\Http\Controllers\test;

use App\Helpers\Payment\PayfortHelper;
use App\PayfortMerchant2;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Session;

class TestController extends Controller
{
    protected $merchantIdentifier ;
    protected $accessCode ;
    protected $RequestPhrase ;
    protected $ResponsePhrase ;
    protected $HashType;
    protected $SandboxMode;

    public function __construct()
    {
        $this->merchantIdentifier = getenv('MERCHANT_IDENTIFIER');
        $this->accessCode = getenv('ACCESS_CODE');
        if(getenv('PAYFORT_STATUS') == "true")
        {
            $this->SandboxMode = true;
            $this->RequestPhrase = '$2y$10$70dwkpDI/';
            $this->ResponsePhrase = '$2y$10$6UfHXoCqi';
        }
        else
        {
            $this->SandboxMode = false;
            $this->RequestPhrase = '$2y$10$70dwkpDI/';
            $this->ResponsePhrase = '$2y$10$6UfHXoCqi';
        }
        $this->SandboxMode = true ;
        $this->merchantIdentifier = "2b371e07";
        $this->accessCode = "hNuBzdiJ6hLi6Yls0VGj";
        $this->HashType = 'sha256'; // this must match what you have set in the Payfort

    }

    public function index(){
        return \request()->all();
        dd('test');
    }
    public function payment( Request $request){
        $locale = \App::getLocale() ;
        $successUrl = url('/'.$locale.$request->get('redirect_url'));
//        Session::put('reservation', $request->all() );

        $pay = new \App\PayfortInstallment();
        $pay->setMerchantIdentifier($this->merchantIdentifier);
        $pay->setMerchantReference($this->generateRandomString());
        $pay->setMerchantAccessCode($this->accessCode);
        $pay->setSandboxMode($this->SandboxMode); // set to false if this is in production
        $pay->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $pay->setResponsePhrase($this->ResponsePhrase); //TESTSHAOUT
        $pay->setRequestPhrase($this->RequestPhrase); //TESTSHAIN
        $data = collect(json_decode($pay->Tokenization($request->all())));
        dd($data);
        $userInfo = Session::get('reservation');
        $data['amount']=$userInfo['amount'] ;
        $data['plan_code'] =$userInfo['plan_code'];
        $data['issuer_code']=$userInfo['issuer_code'];
        $data['currency']='EGP';
        $data['email']=$userInfo['email'];
        $data['name']=$userInfo['card_holder_name'];
        $data['return_url']=$successUrl;

//        return [$data] ;
        return ($pay->Operation($data));
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
    public function payfort(Request $request)
    {
        $locale = \App::getLocale();
        $url = '/'.$locale.'/payfort?action=generate_final_form';
        $successUrl = '/'.$locale.'/payfort?action=payfort_complete_transaction';
        $payment = new PayfortHelper();

        return $payment->pay($url,$successUrl);
    }
    public function payfortOperation(Request $request)
    {
        $p = new PayfortMerchant2();
        $p->setMerchantIdentifier($this->merchantIdentifier);
        $p->setMerchantAccessCode($this->accessCode);
        $p->setSandboxMode($this->SandboxMode); // set to false if this is in production
        $p->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $p->setResponsePhrase($this->RequestPhrase); //TESTSHAOUT
        $p->setRequestPhrase( $this->RequestPhrase); //TESTSHAIN

        $successUrl = '/paymentTest';
        $p->setDefaultCurrency('EGP');
        $p->setAmount('100');
        $p->setServiceCommand('PURCHASE');
        $p->setRememberToken(TRUE);
        $p->setReturnUrl(url($successUrl));
        if (!array_key_exists('card_holder_name', $_REQUEST)) {
            $message = trans("words.booking error message") . ' Invalid card holder name';
            if(\request()->session()->has('url')){
                return redirect(\request()->session()->get('url'))->withErrors([$message, $message]);
            }
            return Redirect::back()->withErrors([$message, $message]);
        }

        $p->setCustomerData(1, $_REQUEST['card_holder_name'], "email");
        $arr = $p->processMerchantRequest($_REQUEST);

//        return $arr;
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

    }
    public function payfortToken(Request $request){
        $p = new PayfortMerchant2();
        $p->setMerchantIdentifier($this->merchantIdentifier);
        $p->setMerchantAccessCode($this->accessCode);
        $p->setSandboxMode($this->SandboxMode); // set to false if this is in production
        $p->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $p->setResponsePhrase($this->RequestPhrase); //TESTSHAOUT
        $p->setRequestPhrase( $this->RequestPhrase); //TESTSHAIN

        $url = '/payfortOperation';
        $exception =  ['card_holder_name','card_number','expiry_year','expiry_month','ccv'];
        foreach ($_REQUEST as $key => $value){
            if(!in_array($key,$exception)){
                unset($_REQUEST[$key]);
            }
        }

        $p->setReturnUrl(url($url));
        $p->setRememberToken(TRUE);

        $p->setMerchantReference($this->generateRandomString());
        echo $p->processRequest(array('paymentMethod'=>'cc_merchant_page_2'));

    }

}
