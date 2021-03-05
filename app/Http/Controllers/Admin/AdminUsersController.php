<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminUsersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Spatie\Permission\Models\Role;
use App\OrderStatus;
class AdminUsersController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_admin');
        $this->middleware('permission:create_admin', ['only' => ['create','store']]);
        $this->middleware('permission:edit_admin', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_admin', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $user = User::admins()->with('roles:name')->get();
        $orderstatus = OrderStatus::all();
        $data = ['rows' => $user , 'orderstatus' => $orderstatus];
        return view('admin.users.index')->with($data);
    }
    
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        $data = ['roles'=>$roles];
        return view('admin.users.create')->with($data);
    }

    
    public function store(AdminUsersRequest $request)
    {
        $request->merge(['is_active' => $request->has('is_active')]);
        $request->merge(['is_admin' => 1]);
        $user = User::create($request->all());
        $user->order_status_permissions = implode(',',$request->input('order_status_permissions'));
        $user->save();
        $role = (!empty($request->input('role'))) ? $request->input('role') : [] ;
        $user->syncRoles($role);
        # log the action to database
        $logPayload = ['msg' => 'Admin Added', 'model_id' => $user->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.users.index');

    }

    public function show($id)
    {
        $user = User::find($id);
        $data = ['row' => $user];
        return view('admin.users.show')->with($data);
    }

    
    public function edit($id)
    {
        $user = User::find($id);
        $orderstatus = OrderStatus::all();
        $roles = Role::get();
        $userRoles = $user->roles()->first();
        $user->role_id = (!empty($userRoles) ) ? $userRoles->id : '';
        $data = ['row' => $user, 'orderstatus' => $orderstatus, 'roles' => $roles->pluck('name', 'id')];
        # log the action to database
        $logPayload = ['msg' => 'Admin Updated', 'model_id' => $user->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return view('admin.users.edit')->with($data);
    }
    
    public function update(AdminUsersRequest $request, $id)
    {

        $request->merge(['is_active' => $request->has('is_active')]);
        $password = (!empty($request->input('password'))) ? Hash::make($request->get('password')) : null;
        $request->merge(['password' => $password]);
        $user = User::find($id);
        $user->update($request->all());
        $user->order_status_permissions = implode(',',$request->input('order_status_permissions'));
        $user->save();
        $role = (!empty($request->input('role'))) ? $request->input('role') : [] ;
        $user->syncRoles($role);
        return redirect()->route('admin.users.index');

    }

    
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users.index');
    }

}
