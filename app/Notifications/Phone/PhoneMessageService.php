<?php

namespace App\Notifications\Phone;
use SoapClient;
use App\PhoneMessage;

class PhoneMessageService {

    private $userName;
    private $password;	
    private $client;
    private $messageLang;
    public  $messageText;	 
    private  $messageSender;
    public $messageReceiver;

    #init cards
    function __construct(){
        $this->userName = env('PHONE_MESSAGE_USERNAME', 'Raneen');
        $this->password = env('PHONE_MESSAGE_PASSWORD', 'XCW99om99o');;;
        $this->client = 'https://smsvas.vlserv.com/KannelSending/service.asmx?WSDL';
        $this->messageLang = env('PHONE_MESSAGE_LANG', 'E');
        $this->messageSender = env('PHONE_MESSAGE_SENDER', 'Raneen');
    }
    
    # send message to phone
    public function sendMessage(){
        
        $client = new SoapClient( $this->client );
        
        $result = $client->SendSMS(
            array(
                "UserName" => $this->userName, 
                "Password" => $this->password, 
                "SMSText" => $this->messageText,
                "SMSLang" => $this->messageLang,
                "SMSSender" => $this->messageSender,
                "SMSReceiver" => $this->messageReceiver
            )
        );

        $statusCode = $result->SendSMSResult;
        $this->logPhoneMessage($statusCode);
        # if 0 then ok
        return $statusCode;
    }

    function logPhoneMessage($status) {
        # log phone message to database
        PhoneMessage::create([
            'text' => $this->messageText,
            'lang' => $this->messageLang,
            'receiver' => $this->messageReceiver,
            'status' => $status
        ]);
    }

}