<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Periorty;
use App\Periortysetting;
use App\Language;
use App\Http\Controllers\Controller;

class PriortyController extends Controller
{
    public function index()
    {
    	$rows=Periorty::orderBy('order_id')->get();
        $priorty_setting=Periortysetting::first();
    	return view('admin.priorty.index',compact('rows','priorty_setting'));
    }

    public function create()
    {
    	$len = Language::all();
    	return view('admin.priorty.create',compact('len'));
    }

    //store
    public function store(Request $request)
    {
    	$rules=[
    		'name'=>'required|unique:periorties,name',
    		'order_id'=>'required'
    	];

    	$request->validate($rules);
    	$data=$request->except('_token');
    	if($rows=Periorty::where('order_id',$request->order_id)->first()){
    		$rows2=Periorty::where('order_id','>=',$request->order_id)->increment('order_id');
    	}

    	Periorty::create($data);
    	return redirect(url('big-boss/priroty'));
    }
    //Edit
    public function edit(Request $request,$id)
    {
    	$row=Periorty::find($id);
    	return view('admin.priorty.edit',compact('row'));
    }
    //Update
    public function update(Request $request,$id)
    {
    	$rules=[
    		'name'=>'required|unique:periorties,name,'.$id,
    		'order_id'=>'required'
    	];

    	$request->validate($rules);
    	$data=$request->except('_token');
    	if($rows=Periorty::where('order_id','=',$request->order_id)->first()){
    		$rows2=Periorty::where('order_id','>=',$request->order_id)->increment('order_id');
    	}
		$row=Periorty::find($id);
		$row->update($data);

    	

    	return redirect(url('big-boss/priroty'));
    }

    //update_all
    public function update_all(Request $request)
    {
    	$order = 1;
    	//dd($request->ids);
        foreach ($request->get('ids') as $id) {
            Periorty::where('id', $id)->update([
                'order_id' => $order
            ]);
            $order++;
        }


        return $request->ajax() ? [] : back();
    }

    //Enable Priroty
    public function toggole(Request $request)
    {
        if($request->ajax()){
            $priorty_setting=Periortysetting::first();
            $priorty_setting->enable==0?$priorty_setting->enable=1:$priorty_setting->enable=0;
            $priorty_setting->save();
            return $priorty_setting->enable;
        }
    }
}
