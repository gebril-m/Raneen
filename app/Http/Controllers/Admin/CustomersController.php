<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AdminUsersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\User;
use App\Country;
use App\City;;
use Hash;
use Spatie\Permission\Models\Role;


class CustomersController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_admin');
        $this->middleware('permission:create_admin', ['only' => ['create','store']]);
        $this->middleware('permission:edit_admin', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_admin', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $user = User::customers()->with('details')->get();
        $data = ['rows' => $user];
        return view('admin.customers.index')->with($data);
    }
    
    public function create()
    {
        $data = [            
            'countries' => Country::all()->pluck('name:en', 'id'),
            'cities' => City::all()->pluck('name:en', 'id')
        ];
        return view('admin.customers.create')->with($data);
    }

    
    public function store(AdminUsersRequest $request)
    {
        $request->merge(['is_active' => $request->has('is_active')]);
        $password = Hash::make($request->get('password'));
        $request->merge(['password' => $password]);
        $user = User::create($request->all());
        $detailsData = $request->except('_method', '_token', 'password', 'password_confirmation', 'is_active', 'name', 'gender', 'dob', 'contact_number');
        $detailsData['email'] = $request->order_email;
        $user->details()->updateOrCreate(['user_id' => $user->id], $detailsData);
        # log the action to database
        $logPayload = ['msg' => 'Customer Added', 'model_id' => $user->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.customers.index');
    }

    public function show($id)
    {
        $user = User::find($id);
        $data = ['row' => $user];
        return view('admin.customers.show')->with($data);
    }

    public function edit($id)
    {
        $user = User::with('details')->find($id);
        $data = [
            'row' => $user,
            'countries' => Country::all()->pluck('name:en', 'id'),
            'cities' => City::all()->pluck('name:en', 'id')
        ];
        return view('admin.customers.edit')->with($data);
    }
    
    public function update(Request $request, $id)
    {
        $request->merge(['is_active' => $request->has('is_active')]);
        $password = (!empty($request->input('password'))) ? Hash::make($request->get('password')) : null;
        $request->merge(['password' => $password]);
        // update user
        $user = User::find($id);
        $user->update($request->all());
        // update user details
        $detailsData = $request->except('_method', '_token', 'password', 'password_confirmation', 'is_active', 'name', 'gender', 'dob', 'contact_number');
        $detailsData['email'] = $request->order_email;
        $user->details()->updateOrCreate(['user_id' => $user->id], $detailsData);
        // log
        $logPayload = ['msg' => 'Customer Updated', 'model_id' => $user->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.customers.index');
    }
    
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $user->details()->delete();
        return redirect()->route('admin.customers.index');
    }

}
