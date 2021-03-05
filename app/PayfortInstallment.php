<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 23/05/19
 * Time: 10:52 ص
 */

namespace App;
use Carbon\Carbon;
use Conceptlz\Payfort\Base\PayfortBase;

use InvalidArgumentException;
use App\Helpers\PayfortLogs;
use Session;

class PayfortInstallment extends PayfortMerchantMobile
{


    public function __construct()
    {
        parent::__construct();

    }



    public function InstallMent($amount,$currency){
        $data = [
            'query_command'=>'GET_INSTALLMENTS_PLANS',
            'merchant_identifier' => $this->getMerchantIdentifier(),
            'access_code' => $this->getMerchantAccessCode(),
            'amount' => $this->convertFortAmount($amount, $currency),
            'currency'=>$currency,
            'language'=>'en',
        ];
        $sign = $this->calculateSignature($data);
        $data['signature'] = $sign ;
        $gatewayUrl = $this->getBaseURL().$this->endpoints['paymentApi'];

        $ch = curl_init($gatewayUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data)))
        );

        $result = curl_exec($ch);
        return $result ;

    }

    public function Tokenization($request){
        $ReturnUrl = url("/paymentTest")   ;
        $data = [
            'merchant_identifier' => $this->getMerchantIdentifier(),
            'access_code' => $this->getMerchantAccessCode(),
            'merchant_reference' => $this->getMerchantReference(),
            'language' => 'en',
            'service_command' => 'TOKENIZATION',
            'return_url' => $ReturnUrl,
        ];
        $sign = $this->calculateSignature($data, 'request');
        $data['signature'] = $sign ;
        $data['expiry_date']= '2101'/*$request['expiry_date']*/;
        $data['card_number']='4005550000000001'/*$request['card_number']*/;
        $data['card_security_code']= '123'/*$request['card_security_code']*/;
        $data['card_holder_name']= 'mohamed'/*$request['card_holder_name']*/;
//        dd($data);
        return $this->formSubmit($data);

    }
    public function Operation($params)
    {
        if($params['status'] != '18'){
            return back()->withErrors(trans('payment.'.$params['response_message']));
        }
        $gatewayUrl = $this->getBaseURL().$this->endpoints['paymentApi'];

        $postData = array(
            'merchant_reference' => $params['merchant_reference'],
            'access_code' => $this->getMerchantAccessCode(),
            'command' => "PURCHASE",
            'merchant_identifier' => $this->getMerchantIdentifier(),
            'customer_ip' => \Request::ip(),
            'amount' => $this->convertFortAmount($params['amount'], $params['currency']),
            'currency' => $params['currency'],
            'customer_email' => trim($params['email']),
            'customer_name' => trim($params['name']),
            'token_name' => $params['token_name'],
            'language' => "en",
            'return_url' => url($params['return_url']) ,
            'installments' => "HOSTED",
            'plan_code' => $params['plan_code'],
            'issuer_code' => $params['issuer_code'],
        );
        $signature = $this->calculateSignature($postData, 'request');
        $postData['signature'] = $signature;
        $array_result = $this->callApi($postData, $gatewayUrl);
        session()->put('reservation_type','installment');
        return $this->handleResponse($array_result);

    }

    public function curl($url, $fields) {
//        dd($fields);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($fields)
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function formSubmit($data) {
        $gatewayUrl = $this->getBaseURL().$this->endpoints['paymentPage'];
        $curl = $this->curl($gatewayUrl, $data);
        preg_match('#var returnUrlParams = (.*?)\;#i', $curl, $return_match);
        preg_match('# action\=\"(.*?)\"#i', $curl, $action);
        return $return_match[1];

    }

    public function handleResponse($response)
    {
        if($response['status'] == '20')

        {
            return redirect($response['3ds_url'], 301);
        }
        else
        {

            if($response['status'] != '14000' )
            {
                $message = trans("words.booking error message") . PHP_EOL .$response['response_message'] ;
                return \Redirect::back()->withErrors([$message, $message]);

            }
            else
            {
                $userData = Session::get('userInfo');
                $query = DB::table('prebooking')
                    ->where('email', $userData['email'])
                    ->update(['fort_id' => $response['fort_id']]);

                return redirect($response['3ds_url']);

            }
        }

    }
    public function Fawry($currency ,$amount,$name,$email,$expire){
        $expire = Carbon::parse($expire)->toIso8601String();

        $data = [
            'service_command' => 'BILL_PRESENTMENT',
            'merchant_identifier' => $this->getMerchantIdentifier(),
            'access_code' => $this->getMerchantAccessCode(),
            'merchant_reference' => $this->getMerchantReference(),
            'language' => $this->language,
            'request_expiry_date'=>$expire ,/*'2019-12-20T15:36:55+03:00'*/
            'payment_partner'=>'FAWRY',
            'amount' => $this->convertFortAmount($amount, $currency),
            'customer_name' => $name,
            'customer_email' => $email,
            'currency'=>$currency,
        ];
        $sign = $this->calculateSignature($data);
        $data['signature'] = $sign ;
        $gatewayUrl = $this->getBaseURL().$this->endpoints['paymentApi'];
        $ch = curl_init($gatewayUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data)))
        );

        $result = curl_exec($ch);
        return $result ;

    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}