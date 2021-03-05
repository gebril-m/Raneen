<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PermissionGroup;
use App\Http\Requests\PermissionsGroupsRequest;

class PermissionsGroupsController extends Controller
{
    
    public function __construct(){
        $this->middleware('permission:view_role');
        $this->middleware('permission:create_role', ['only' => ['create','store']]);
        $this->middleware('permission:edit_role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }

    public function index()
    {
        $rows = PermissionGroup::get();
        $data['rows'] = $rows;
        return view('admin.access.permissionsGroups.index')->with($data);
    }

    public function create()
    {
        $data['groups'] = PermissionGroup::get()->pluck('name', 'id');
        return view('admin.access.permissionsGroups.create')->with($data);
    }

    public function store(PermissionsGroupsRequest $request)
    {
        $permission = PermissionGroup::create( ['name' => $request->input('name'), 'group_id' => $request->input('group_id')] );
        $logPayload = ['msg' => 'Permission Group Added', 'model_id' => $permission->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.permgroups.index');
    }

    public function show($id)
    {
        $row = PermissionGroup::find($id);
        $data['row'] = $row;
        return view('admin.access.permissionsGroups.create')->with($data);
    }

    public function edit($id)
    {
        $row = PermissionGroup::find($id);
        $data['row'] = $row;
        return view('admin.access.permissionsGroups.edit')->with($data);
    }

    public function update(PermissionsGroupsRequest $request, $id)
    {   
        $permission = PermissionGroup::find($id);
        $permission->update( $request->all() );
        $logPayload = ['msg' => 'Permission Group Updated', 'model_id' => $permission->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.permgroups.index');    
    }

   public function destroy($id)
    {
        PermissionGroup::find($id)->delete();
        return redirect()->route('admin.permgroups.index');
    }
}
