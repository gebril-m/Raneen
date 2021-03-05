<?php

namespace App\Http\Controllers\Admin;

use App\Subscribers;
use Illuminate\Http\Request;
use App\Http\Requests\AdminUsersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
class SubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('permission:view_admin');
        $this->middleware('permission:create_admin', ['only' => ['create','store']]);
        $this->middleware('permission:edit_admin', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_admin', ['only' => ['destroy']]);
    }
    public function index()
    {
        $subscribers = Subscribers::all();
        $data = ['rows' => $subscribers];
        return view('admin.subscribers.index')->with($data);
    }
    
    public function create()
    {

    }

    
    public function store(AdminUsersRequest $request)
    {
        
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }
    
    public function update(Request $request, $id)
    {

    }
    
    public function destroy($id)
    {

    }
}
