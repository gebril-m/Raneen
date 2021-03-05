<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCode;

class VerificationController extends Controller
{

    // show form only
    function verifyForm(){
        return view('auth.verify');
    }

    // verification code confirm
    function verify(Request $request){
        $uid = auth()->user()->id;
        $userInsertedCode = $request->verification_code;
        $user = User::findOrFail($uid);
        $code = $user->verification_code;
        if($userInsertedCode == $code){
            $user->update(['email_verified_at' => Carbon::now()]);
        } else {
            return redirect()->route('web.account.verify.show')->with('verification_error', __('Login.Verification Code Mismatch'));
        }
        // verification success
        if($request->session()->has('url'))
        {
            $value = $request->session()->pull('url');

            return redirect($value);
        }
        return redirect('/');
    }


    // resend verification code
    function resend(){
        $user = auth()->user();
        $code = User::findOrFail($user->id)->verification_code;
        // email
        Mail::to($user->email)->send(new VerificationCode($code) );
        // phone sms
        $sms = 'Your Account Verification Code Is: ' . $code;
        sendPhoneMessageNotification($sms, $user->contact_number );
        return redirect()->route('web.account.verify.show')->with('verification_code_resent', 1);
    }

}
