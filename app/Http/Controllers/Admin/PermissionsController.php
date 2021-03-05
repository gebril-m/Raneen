<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionsRequest;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\PermissionGroup;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_role');
        $this->middleware('permission:create_role', ['only' => ['create','store']]);
        $this->middleware('permission:edit_role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }

    public function index()
    {
        $rows = Permission::get();
        $data['rows'] = $rows;
        return view('admin.access.permissions.index')->with($data);
    }

    public function create()
    {
        $data['groups'] = PermissionGroup::get()->pluck('name', 'id');
        return view('admin.access.permissions.create')->with($data);
    }

    public function store(PermissionsRequest $request)
    {
        $permission = Permission::create( ['name' => $request->input('name'), 'group_id' => $request->input('group_id')] );
        $logPayload = ['msg' => 'Permission Added', 'model_id' => $permission->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);       
        return redirect()->route('admin.permissions.index');

    }

    public function show($id)
    {
        $row = Permission::find($id);
        $data['row'] = $row;
        return view('admin.access.permissions.create')->with($data);
    }

    public function edit($id)
    {
        $row = Permission::find($id);
        $data['row'] = $row;
        $data['groups'] = PermissionGroup::get()->pluck('name', 'id');
        return view('admin.access.permissions.edit')->with($data);
    }

    public function update(PermissionsRequest $request, $id)
    {   
        $permission = Permission::find($id);
        $permission->update( $request->all() );
        $logPayload = ['msg' => 'Permission Updated', 'model_id' => $permission->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.permissions.index');    
    }

   public function destroy($id)
    {
        Permission::find($id)->delete();
        return redirect()->route('admin.permissions.index');
    }
}
