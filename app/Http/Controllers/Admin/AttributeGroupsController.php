<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Attribute;
use App\AttributeCategory;
use App\Category;
use App\Http\Requests\AttributesRequest;
use App\AttributeTranslation;

class AttributeGroupsController extends Controller
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
        $attrs = Attribute::parents()->get();
        $data = ['rows'=>$attrs];
        return view('admin.attributeGroups.index')->with($data);
    }

    public function create()
    {
        $categories=Category::all();
        return view('admin.attributeGroups.create',compact('categories'));
    }

    public function store(AttributesRequest $request)
    {
        //dd($request->category_id);
        $request->merge(['is_active' => $request->has('is_active')]);
        $attribute = Attribute::create($request->all());
        $attribute->categories()->sync($request->category_id);

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
        $logPayload = ['msg' => 'Attribute Group Added', 'model_id' => $attribute->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.attrgroups.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'row'=>Attribute::findOrFail($id), 
            'groups'=>Attribute::parents()->get()->pluck('name:en', 'id'),
            'categories'=>Category::all()
        ];
        // $row=Attribute::findOrFail($id);
        // dd($row->getCategoriesId());
        return view('admin.attributeGroups.edit')->with($data);
    }

    public function update(AttributesRequest $request, $id)
    {
        $request->merge(['is_active' => $request->has('is_active')]);
        $attribute = Attribute::findOrFail($id);
        $attribute->update($request->all());
        $attribute->categories()->sync($request->category_id);
        $childCatIds=Category::whereIn('parent_id',$request->category_id)->pluck('id')->toArray();
        $attribute->categories()->sync($childCatIds); #sync children products

        $attIds=$attribute->childrens()->pluck('id')->toArray();
        AttributeCategory::whereIn('attribute_id',$attIds)->delete();
       //dd($attribute->childrensRow()->get());
        foreach ($attribute->childrensRow()->get() as $childAttr) {
            $childAttr->categories()->sync($request->category_id);
           
        }
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
        $logPayload = ['msg' => 'Attribute Group Updated', 'model_id' => $attribute->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.attrgroups.index');
    }

    public function destroy($id)
    {
        Attribute::find($id)->categories()->sync([]);
        Attribute::find($id)->delete();
        return redirect()->route('admin.attrgroups.index');
    }
}
