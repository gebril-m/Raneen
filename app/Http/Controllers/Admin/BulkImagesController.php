<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AdminUsersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class BulkImagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permission:view_admin');
        $this->middleware('permission:create_admin', ['only' => ['create','store']]);
        $this->middleware('permission:edit_admin', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_admin', ['only' => ['destroy']]);
    }
    public function index(){
    	return view('admin.images.index');
    }
    public function store(Request $request){
        if($request->hasFile('image')){
            foreach($request->file('image') as $image){
                upload_file_original($image, $request->input('type'));
            }
            return redirect()->back()->withErrors(['Uploaded Done']);
        }else{
            return redirect()->back()->withErrors(['No Photos Selected']);
        }
    }
}
