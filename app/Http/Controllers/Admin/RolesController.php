<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\RolesRequest;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_role');
        $this->middleware('permission:create_role', ['only' => ['create','store']]);
        $this->middleware('permission:edit_role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $data['rows'] = Role::with('permissions')->get();
        return view('admin.access.roles.index')->with($data);
    }

    public function create()
    {
        $data['permissions'] = Permission::get();
        return view('admin.access.roles.create')->with($data);
    }

    public function store(Request $request)
    {
            
        $request->validate([
            'name' => 'required'
        ]);

        # create role
        $role = Role::create(['name' => $request->input('name')]);    
        # sync permissions to role
        $role->syncPermissions($request->input('permissions'));
        $logPayload = ['msg' => 'Role Added', 'model_id' => $role->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);  
        return redirect()->route('admin.roles.index');    
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['row'] = Role::with('permissions')->find($id);
        $data['permissions'] = Permission::get();
        return view('admin.access.roles.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        # create role
        $role = Role::find($id);
        $role->update(['name'=>$request->input('name')]);    
        # sync permissions to role
        $role->syncPermissions($request->input('permissions'));
        $logPayload = ['msg' => 'Role Updated', 'model_id' => $role->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);  
        return redirect()->route('admin.roles.index');
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect()->route('admin.roles.index');
    }

}
