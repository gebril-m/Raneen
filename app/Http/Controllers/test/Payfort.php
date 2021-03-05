<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 27/05/19
 * Time: 12:25 م
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\PayfortInstallment;
use App\Http\Requests;
use App\PayfortMerchant2;
use Illuminate\Support\Carbon;
class Payfort extends Controller
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
            $this->ResponsePhrase = '$2y$10$70dwkpDI/';
        }
        else
        {
            $this->SandboxMode = false;
            $this->RequestPhrase = '$2y$10$70dwkpDI/';
            $this->ResponsePhrase = '$2y$10$70dwkpDI/';
        }
        $this->HashType = 'sha256'; // this must match what you have set in the Payfort

    }
    public function Fawry(Request $request){
        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $amount = $request->get('amount');
        $currency = $request->get('currency');
        $expire = $request->get('expire');
        $booking_id = $request->get('booking_id');
        $pay = new \App\PayfortInstallment();
        $pay->setMerchantIdentifier($this->merchantIdentifier);
        $pay->setMerchantAccessCode($this->accessCode);
        $pay->setMerchantReference($pay->generateRandomString());
        $pay->setSandboxMode($this->SandboxMode); // set to false if this is in production
        $pay->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $pay->setResponsePhrase($this->ResponsePhrase); //TESTSHAOUT
        $pay->setRequestPhrase($this->RequestPhrase); //TESTSHAIN
        $fawry = collect(json_decode($pay->Fawry($currency, $amount , $name,$email,$expire)));
        unset($fawry['merchant_identifier']);
        unset($fawry['access_code']);
        unset($fawry['signature']);
//        dd($fawry);
        $cach_id = $request->get('cach_id') ;
        if($request->has('cach_id')){
                $cach = \Cache::get($cach_id);
                if(isset($cach['hotel'])){
                    $type = "hotels";
                    $serverMail = "reservation@travelyalla.com";
                }else{
                    $type = "flights";
                    $serverMail = "airlines@travelyalla.com";

                }
            sleep(1);
            $this->sendMailServer($fawry,$serverMail, $type);
            sleep(1);
            $this->sendMailCustomer($fawry,$type);
            \DB::table('fawry_logs')->insert(
                ['name'=>$name,'email'=>$email ,'phone'=>$phone,'amount'=>$amount
                    ,'expire_at'=>Carbon::parse($expire),'bill_number'=>$fawry['bill_number'],
                    'booking_id' => $booking_id,
                    'logs'=>json_encode($cach),'type'=>$type]
            );
        }
        return response()->json($fawry);
    }
    public function InstallMent(Request $request){
        $amount = $request->get('amount');
        $currency = $request->get('currency');
        $pay = new \App\PayfortInstallment();
        $pay->setMerchantIdentifier($this->merchantIdentifier);
        $pay->setMerchantAccessCode($this->accessCode);
        $pay->setMerchantReference($pay->generateRandomString());
        $pay->setSandboxMode($this->SandboxMode); // set to false if this is in production
        $pay->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $pay->setResponsePhrase($this->ResponsePhrase); //TESTSHAOUT
        $pay->setRequestPhrase($this->RequestPhrase); //TESTSHAIN
        $response = collect(json_decode($pay->InstallMent($amount,$currency)));
        return response()->json($response);

    }
    public function payment( Request $request){
        $locale = \App::getLocale() ;
        $successUrl = url('/'.$locale.$request->get('redirect_url'));
        Session::put('reservation', $request->all() );

        $pay = new \App\PayfortInstallment();
        $pay->setMerchantIdentifier($this->merchantIdentifier);
        $pay->setMerchantReference($this->generateRandomString());
        $pay->setMerchantAccessCode($this->accessCode);
        $pay->setSandboxMode($this->SandboxMode); // set to false if this is in production
        $pay->setHashType('sha256'); // this must match what you have set in the Payfort Console
        $pay->setResponsePhrase($this->ResponsePhrase); //TESTSHAOUT
        $pay->setRequestPhrase($this->RequestPhrase); //TESTSHAIN

        $data = collect(json_decode($pay->Tokenization($request->all())));
        $userInfo = Session::get('reservation');
        $data['amount']=$userInfo['amount'] ;
        $data['plan_code'] =$userInfo['plan_code'];
        $data['issuer_code']=$userInfo['issuer_code'];
        $data['currency']=$this->currency;
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
    public function bee(Request $request){
        return response()->json(['response'=>'success']);
    }
    public function sendMailServer($data,$serverMail, $type){


        $content = '';
        if($type == 'hotels') {
            $cach_id = \request()->get('cach_id') ;
            $reservation = Session::get('reservationData') ;
            $cach = \Cache::get($cach_id);
            if(isset($reservation['hotel_name'])){
                $hotelName = $reservation['hotel_name'];
            }else{
                $hotelName = $cach['hotel']['name']['en'] ?? '';
            }
            if(isset($reservation['hotel_address'])){
                $address = $reservation['hotel_address'];
            }
            else{
                $address = $reservation['destination'];
            }

            $content .= 'Hotel Name: ' .trim( $hotelName) . PHP_EOL;
            $content .= '                Check in: ' . $reservation['check_in'] . PHP_EOL;
            $content .= '                Check out: ' . $reservation['check_out'] . PHP_EOL;
            $content .= '                Hotel code: ' . $reservation['hotel_code'] . PHP_EOL;
            if(isset($reservation['promoCode'])){
                $content .= '                Promo Code: ' . $reservation['promoCode'] . PHP_EOL;
            }
            $content .= '                Address: ' . $address. PHP_EOL;
            $content .= '                Price: ' . $reservation['price'] .' '.$reservation['currency'] . PHP_EOL;
            $content .= '                Cost: ' . $reservation['cost'] .' USD'. PHP_EOL;
            $content .= '                Rooms info: ' . $reservation['rooms_info'] . PHP_EOL;
            $content .= '                Mobile: ' . $reservation['country_code'] .' '.$reservation['mobile'] . PHP_EOL;
            $content .= '                Nationality: ' . $this->nationality . PHP_EOL;

        }

        Mail::raw(<<<HTML
                Hi,
                Please check this booking (Fawry)
                Fawry Id: ${data['bill_number']}
                Username: ${data['customer_name']}
                E-Mail: ${data['customer_email']}
                
                $content
                Thanks
HTML
            , function ($message) use($serverMail) {
                // "reservation@travelyalla.com"
                $message->from('reservation@travelyalla.com', 'Travelyalla');
                $message->to($serverMail)
                    ->subject("Booking Reminder");
            });

    }
    public function sendMailCustomer($data ,$type){
        if($type == "hotels"){
            $cach_id = \request()->get('cach_id') ;
            $reservation = Session::get('reservationData') ;
            $cach = \Cache::get($cach_id);
//            dd(json_decode($reservation['cancellation_policies']));
//            dd($cach['roomDetails']['rooms']);
            Mail::send('email.fawryInvoice',
                ['reservation' => $reservation,
                    'data'=>$data,
                    'cach'=>$cach]
                , function ($m) use ($reservation,$data,$cach) {
                $m->from('reservation@travelyalla.com', 'Travelyalla');
                $m->to($data['customer_email'], $data['customer_name'])->subject(trans('words.Travelyalla Successful fawry Booking'));
            });

        } else if ($type == 'flights') {
            $reservation = json_encode(Session::get('reservationData')) ;
            $reservation = \json_decode($reservation, true);
            Mail::send('email.bookingflight', [
                'reservation'   => $reservation,
                'data'          => $data,
                'info'          => $reservation,
            ], function ($m) use ($reservation,$data) {
                $m->from('reservation@travelyalla.com', 'Travelyalla');
                $m->to($data['customer_email'], $data['customer_name'])->subject(trans('words.Travelyalla Successful fawry Booking'));
            });
        }
    }

}