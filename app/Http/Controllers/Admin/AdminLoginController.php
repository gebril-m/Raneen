<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    
    public function showAdminLoginForm() {
        if(Auth::check()){
            if(Auth::user()->is_admin){
                return redirect()->route('admin.home');
            }

        }
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {

        $request->validate([
            'email'   => 'required|email',
            'password' => 'required'
        ]);

        if ( Auth::attempt(
                    [
                        'email' => $request->email, 
                        'password' => $request->password,
                        'is_admin' => 1
                    ], $request->get('remember'))) 
        {
            $back =route('admin.home') ;
            if(session()->has('lastPage')){
               $back =  session()->get('lastPage');
            }
            return redirect($back);
        }

        return back()->with('message', 'Error With Email Or Password');

    } 

    public function adminLogout(){
        session()->put('lastPage',URL::previous());
        Auth::logout();
        return redirect()->route('admin.login');

    }       

}
