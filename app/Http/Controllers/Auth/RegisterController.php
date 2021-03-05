<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCode;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            // 'contact_number' => 'regex:/(01)[0-9]{9}/|size:11',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => 'required|captcha',
            'accept' => ['required'],
            'contact_number'=> ['required','numeric']
        ]);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd($data);
        $code = genRandomCode();

        // save user data
        $user = User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'verification_code' => $code,
            'contact_number' => $data['contact_number'],
            'dob' => $data['dob'],
            'password' => Hash::make($data['password']),
            'is_active' => 1
        ]);

        // save details data
        UserDetail::create([
            'first_name' => $data['name'],
            'user_id' => $user->id,
            'email' => $data['email'],
            'phone' => $data['contact_number']

        ]);

        // email
        #Mail::to($data['email'])->send(new VerificationCode($code) );
        // phone sms
        $sms = 'Your Raneen Account Verification Code Is ' . $code;
        // sendPhoneMessageNotification($sms, $data['contact_number']);
        return $user;
    }
}
