<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Country;
use App\City;
use App\State;
use Illuminate\Support\Facades\Hash;
use App\UserDetail;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }
    public function showProfile(){
        $uid = Auth::user()->id;
        $user = User::with('details')->findOrFail($uid);
        $countries = Country::all();
        $cities = City::all();
        $states = State::all();
        return view('website.users.profile')->with(compact('user', 'countries', 'cities','states'));
    }

    public function updateProfile(Request $request){
        $request->validate([
            'first_name' => ['required', 'alpha_num', 'max:255'],
            'last_name' => ['nullable', 'alpha_num', 'max:255'],
            'email' => 'email|nullable',
            'password' => 'min:8|confirmed|nullable',
            'phone' => 'regex:/(01)[0-9]{9}/|size:11|nullable',
            'contact_number' => 'regex:/(01)[0-9]{9}/|size:11||nullable',
        ]);

        $password = (!empty($request->input('password'))) ? Hash::make($request->get('password')) : null;

        # user
        $uid = auth()->user()->id;
        $user = User::findOrFail($uid);
        $u = $user->update(
            [
                'password' => $password,
                'contact_number' => $request->contact_number,
                'dob' => $request->dob,
                'gender' => $request->gender
            ]
        );
        # details
        UserDetail::updateOrCreate(['user_id' => $uid], $request->all());
        if($request->session()->has('url'))
        {
            $value = $request->session()->pull('url');

            return redirect($value)->with('msg', __('user.update success'));
        }
        return redirect()->back()->with('msg', __('user.update success'));

    }
}
