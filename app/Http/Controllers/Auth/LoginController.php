<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
//    public function login(Request $request){
//        if($request->session()->has('url'))
//        {
//            $value = $request->session()->pull('url');
//
//            return redirect($value);
//        }
//        return redirect('/');
//
//    }

    public function showLoginForm()
    {
        if (!session()->has('url.intended')) {
            redirect()->setIntendedUrl(url()->previous());
        }
        return view('auth.login');
    }

    protected function credentials(Request $request)
    {
        $cards = $request->only($this->username(), 'password');
        $cards['is_active'] = 1;
        return $cards;
    }

    // public function logout(Request $request)
    // {
    //     $this->guard()->logout();
    //     return $this->loggedOut($request) ?: redirect('/');
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = URL::previous();
        $this->middleware('guest')->except('logout');
    }
}
