<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\UserDetail;
use Socialite;
use App\User;
use Carbon\Carbon;

class SocialLoginController extends Controller
{
    function facebookRedirectToProvider(){
        return Socialite::driver('facebook')->redirect();
    }

    function facebookHandleProviderCallback(){
        // user instance
        $user = Socialite::driver('facebook')->user();
        return $this->createUser($user, 'facebook');
    }

    function googleRedirectToProvider(){
        return Socialite::driver('google')->redirect();
    }

    function googleHandleProviderCallback(){
        // user instance
        $user = Socialite::driver('google')->user();
        return $this->createUser($user, 'google');
    }

    function twitterRedirectToProvider(){
        return Socialite::driver('twitter')->redirect();
    }

    function twitterHandleProviderCallback(){
        // user instance
        $user = Socialite::driver('twitter')->user();
        return $this->createUser($user, 'twitter');
    }

    function createUser($user, $provider){
        // user accepted the driver api
        if($user){
            $userName = $user->getName();
            $userEmail = $user->getEmail() ?: '';
            // add this user to database
            $userDatabaseRecord = User::where('email', $user->getEmail())->first();
            if(!$userDatabaseRecord){
                $userDatabaseRecord = User::create([
                    'name' => $userName,
                    'email' => $userEmail,
                    'provider' => $provider,
                    'email_verified_at' => Carbon::now()
                ]);
                // save details data
                UserDetail::create([
                    'first_name' => $userName,
                    'user_id' => $userDatabaseRecord->id,
                    'email' => $userEmail
                ]);
            }
            auth()->login($userDatabaseRecord);
        }
        return redirect()->to('home');
    }


}
