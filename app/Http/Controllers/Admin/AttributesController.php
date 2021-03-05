<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AttributesRequest;
use App\Http\Controllers\Controller;
use App\Attribute;
use App\AttributeTranslation;
use App\AttributeGroup;
use App\Language;
use App\AttributeCategory;

class AttributesController extends Controller
{

    public function __construct(){
        $this->middleware('permission:view_attribute');
        $this->middleware('permission:create_attribute', ['only' => ['create','store']]);
        $this->middleware('permission:edit_attribute', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_attribute', ['only' => ['destroy']]);
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }
    
    public function index()
    {
        $attrs = Attribute::childrens()->get();
        $data = ['rows'=>$attrs];        
        return view('admin.attributes.index')->with($data);
    }

    public function create()
    {
        $data = [
            'groups'=>Attribute::parents()->get()->pluck('name:en', 'id')
        ];
        return view('admin.attributes.create')->with($data);
    }

    public function store(AttributesRequest $request)
    {

        $request->merge(['is_active' => $request->has('is_active')]);
        $attribute = Attribute::create($request->all());
        $cat_ids=AttributeCategory::where('attribute_id',$request->group_id)->pluck('category_id')->toArray();
        $attribute->categories()->sync($cat_ids);

        # fill translations
        $insertArr = [];
        foreach($request->input('name') as $k => $name){
            $insertArr[] = [
                'locale' => $k,
                'name' => $name,
                'attribute_id' => $attribute->id
            ];
        }
        AttributeTranslation::insert($insertArr);
        # log the action to database
        $logPayload = ['msg' => 'Attribute Added', 'model_id' => $attribute->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.attributes.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'row'=>Attribute::findOrFail($id), 
            'groups'=>Attribute::parents()->get()->pluck('name:en', 'id')
        ];
        return view('admin.attributes.edit')->with($data);
    }

    public function update(AttributesRequest $request, $id)
    {
        $request->merge(['is_active' => $request->has('is_active')]);
        $attribute = Attribute::findOrFail($id);
        $attribute->update($request->all());
        $cat_ids=AttributeCategory::where('attribute_id',$request->group_id)->pluck('category_id')->toArray();
        $attribute->categories()->sync($cat_ids);
        # fill translations
        $insertArr = [];
        foreach($request->input('name') as $k => $name){
            $insertArr[] = [
                'locale' => $k,
                'name' => $name
            ];
        }
        $attribute->translations()->delete();
        $attribute->translations()->createMany( $insertArr );
        # log the action to database
        $logPayload = ['msg' => 'Attribute Updated', 'model_id' => $attribute->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.attributes.index');
    }

    public function destroy($id)
    {
        Attribute::find($id)->categories()->sync([]);
        Attribute::find($id)->delete();
        return redirect()->route('admin.attributes.index');
    }

}
