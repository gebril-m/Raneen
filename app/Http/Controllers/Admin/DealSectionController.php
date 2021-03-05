<?php

namespace App\Http\Controllers\Admin;

use App\DealSection;
use App\Product;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Language;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\DealSectionTranslation;
use App\ProductCategory;
use App\Category;

class DealSectionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view_dealsection');
        // $this->middleware('permission:create_dealsection', ['only' => ['create','store']]);
        // $this->middleware('permission:edit_dealsection', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete_dealsection', ['only' => ['destroy']]);
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }
    public function get_products($id){
        $products = ProductCategory::where('category_id','=',$id)->get();
        $arr = [];
        foreach ($products as $product) {
            $product_check = Product::find($product->product_id);
            if($product_check){
                if(!in_array($product_check->id, $arr)){
                    array_push($arr, $product_check->id);
                }
            }
        }
        return $arr;
    }
    public function index()
    {

    	$query = DealSection::query();
        $sections = $query->get();

        $data = ['rows' => $sections];
        return view('admin.dealsection.index')->with($data);
    }

    public function create()
    {
        $products = Product::all();
        $cats = Category::all();

        return view('admin.dealsection.create', compact('products','cats'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name.*' => 'required',
        ]);
        $dealsection = new DealSection();
        $dealsection->product_ids = implode(',',$request->get('product_ids'));
        $dealsection->is_home = ($request->get('is_home') == 'on') ? 1 : 0;
        $dealsection->is_active = ($request->get('is_active') == 'on') ? 1 : 0;
        $dealsection->start_date = $request->get('start_date');
        $dealsection->end_date = $request->get('end_date');
        $dealsection->discount = $request->get('discount');
        $dealsection->save();

        foreach($this->languages as $local){
            $dealsectionTrans = new DealSectionTranslation();
            $dealsectionTrans->name = $request->input('name.'.$local->locale);
            $dealsectionTrans->slug = $request->input('slug.'.$local->locale);
            $dealsectionTrans->deal_section_id = $dealsection->id;
            $dealsectionTrans->locale = $local->locale;
            $dealsectionTrans->save();
        }

        # Category::create($request->all());
        $logPayload = ['msg' => 'Deal Section Added', 'model_id' => $dealsection->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.dealsection.index');

    }

    public function show(DealSection $dealsection)
    {
        $data = ['row' => $dealsection];
        return view('admin.dealsection.show')->with($data);
    }


    public function edit(DealSection $dealsection)
    {

        $cats = Category::all();
        $dbCat = DealSection::where('id', '!=', $dealsection->id)->get();
        $products = Product::all();

        $data = [
            'row'           => $dealsection,
            'products'    => $products,
            'cats'    => $cats,
        ];
        return view('admin.dealsection.edit')->with($data);
    }

    public function update(Request $request, DealSection $dealsection)
    {

        $request->validate([
            'name.*' => 'required',
        ]);

        $dealsection->product_ids = implode(',',$request->get('product_ids'));
        $dealsection->is_home = ($request->get('is_home') == 'on') ? 1 : 0;
        $dealsection->is_active = ($request->get('is_active') == 'on') ? 1 : 0;
        $dealsection->start_date = $request->get('start_date');
        $dealsection->end_date = $request->get('end_date');
        $dealsection->discount = $request->get('discount');
        $dealsection->save();
        foreach($this->languages as $local){
            $dealsectionTrans = DealSectionTranslation::where([
                'deal_section_id' => $dealsection->id,
                'locale' => $local->locale,
            ])->first();
            if (!$dealsectionTrans) $dealsectionTrans = new DealSectionTranslation();
            $dealsectionTrans->deal_section_id = $dealsection->id;
            $dealsectionTrans->name = $request->input('name.'.$local->locale);
            $dealsectionTrans->slug = $request->input('slug.'.$local->locale);
            $dealsectionTrans->locale = $local->locale;
            $dealsectionTrans->save();
        }
        $logPayload = ['msg' => 'Deal Sections Updated', 'model_id' => $dealsection->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.dealsection.index');

    }


    public function destroy(DealSection $dealsection)
    {

        $dealsectionTrans = DealSectionTranslation::where('deal_section_id','=',$dealsection->id)->delete();
        $dealsection->delete();
        return redirect()->route('admin.dealsection.index');
    }
}
