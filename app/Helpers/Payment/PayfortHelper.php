<?php

namespace App\Helpers\Payment;
use App\Helpers\PayfortLogs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use Mockery\Exception;
use Input;
use Validator;
use Carbon\Carbon ;
use DB;
use Cookie ;
use App\PayfortMerchant2 ;
use Session;
use URL ;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller ;
/**
* 
*/
class PayfortHelper extends Controller
{
	protected $merchantIdentifier ;
	protected $accessCode ;
	protected $RequestPhrase ;
	protected $ResponsePhrase ;
	protected $HashType;
	protected $SandboxMode;

	function __construct()
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
      $this->HashType = 'sha256'; // this must match what you have set in the Payfort
       // set to false if this is in production
      //$this->SandboxMode = getenv('PAYFORT_STATUS'); // set to false if this is in production

    }

	function pay($url,$successUrl)
	{
        $p = new PayfortMerchant2();

//        4005550000000001
        $p->setMerchantIdentifier($this->merchantIdentifier);
        $p->setMerchantAccessCode($this->accessCode);
        $p->setSandboxMode($this->SandboxMode); // set to false if this is in production
        $p->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $p->setResponsePhrase($this->RequestPhrase); //TESTSHAOUT
        $p->setRequestPhrase( $this->RequestPhrase); //TESTSHAIN
        if(isset($_POST['action']) && $_POST['action']!='') {

            if($_POST['action'] == 'generate_final_form') {
                unset($_POST['action']);
//                unset($_POST['device_fingerprint']);
                $exception =  ['card_holder_name','card_number','expiry_year','expiry_month','ccv' , 'currency'];
                foreach ($_REQUEST as $key => $value){
                    if(!in_array($key,$exception)){
                        unset($_REQUEST[$key]);
                    }
                }

                $p->setReturnUrl(url($url),$_POST);
                $p->setRememberToken(TRUE);

                $p->setMerchantReference(rand(1, getrandmax()));
//                $dataRes =  json_decode($p->processRequest(array('paymentMethod'=>'cc_merchant_page_2')));
                echo $p->processRequest(array('paymentMethod'=>'cc_merchant_page_2'));
            }

        }
        if (isset($_GET['action']) && $_GET['action'] == 'payfort_complete_transaction') {
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

            return $this->handleResponse($arr);



        }
    }
    public function token($url){
        $exception =  ['card_holder_name','card_number','expiry_year','expiry_month','ccv' , 'currency'];
        foreach ($_REQUEST as $key => $value){
            if(!in_array($key,$exception)){
                unset($_REQUEST[$key]);
            }
        }

        $p->setReturnUrl(url($url),$_POST);
        $p->setRememberToken(TRUE);

        $p->setMerchantReference(rand(1, getrandmax()));
//                $dataRes =  json_decode($p->processRequest(array('paymentMethod'=>'cc_merchant_page_2')));
        echo $p->processRequest(array('paymentMethod'=>'cc_merchant_page_2'));

    }
    public function operation($url){

    }
    function GetRequest(){
        $data = session('payfort');
        session()->forget('payfort');

          if($data){
               // unset($data['request']);
                unset($data['response']['params']['check_3ds']);
                unset($data['response']['params']['remember_me']);
                return $data ;
            }
            return trans("words.booking error message") ;
    }
    function handleResponse($response)
    {
        if($response['response']['params']['status'] == '20')

        {
            $userData = Session::get('userInfo');
            $query = DB::table('prebooking')
                ->where('email', $userData['email'])
                ->update(['fort_id' => $response['response']['params']['fort_id']]);
            return redirect($response['response']['params']['3ds_url']);
        }
        else
        {

            if($response['response']['params']['status'] != '14000' )
            {
                $message = trans("words.booking error message") . PHP_EOL .$response['response']['message'] ;
                Request()->session()->put('errorCars',$message);
                return Redirect::back()->withErrors([$message, $message]);

            }
            else
            {
                $userData = Session::get('userInfo');
                $query = DB::table('prebooking')
                    ->where('email', $userData['email'])
                    ->update(['fort_id' => $response
                    ['response']['params']['fort_id']]);

                return redirect($response['response']['params']['3ds_url']);

            }
        }

    }
}


