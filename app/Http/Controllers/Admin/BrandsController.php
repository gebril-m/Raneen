<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\BrandTranslation;
use App\Exports\BrandsExport;
use App\Imports\BrandsImport;
use App\Language;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class BrandsController extends Controller
{
    public function __construct()
    {
        // permissions
        $this->middleware('permission:view_brand');
        $this->middleware('permission:create_brand', ['only' => ['create','store']]);
        $this->middleware('permission:edit_brand', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_brand', ['only' => ['destroy']]);

        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {
    	$query = Brand::query();

        $query->orderBy('id', 'desc');

    	if (\request()->get('brand'))
    	    $query->whereParentId(\request()->get('brand'));

        $brand = $query->get();

        $data = ['rows' => $brand];
        return view('admin.brands.index')->with($data);
    }

    public function import() {
        Excel::import(new BrandsImport,request()->file('file'));
        return back();
    }

    public function export() {
        return Excel::download(new BrandsExport, 'brands.xlsx');
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.*' => 'required|unique:brand_translations,name',
            # 'slug.*' => 'required|unique:brand_translations,slug',
        ]);

        $brand = new Brand();

        $logo = upload_file($request->file('logo'), 'brands');
        if ($logo) $brand->logo = $logo;

        # $brand->is_active = $request->get('active') == "on" ? 1 : 0 ;
        # $brand->parent_id = $request->get('parent_id');
        $brand->save();

        foreach($this->languages as $local){
            $brandTrans = new BrandTranslation();
            $brandTrans->brand_id = $brand->id;
            $brandTrans->name = $request->input('name.'.$local->locale);

            $brandTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $brandTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $brandTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $brandTrans->locale = $local->locale;
            $brandTrans->save();
        }

        # Brand::create($request->all());
        # log the action to database
        $logPayload = ['msg' => 'Brand Added', 'model_id' => $brand->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.brands.index');

    }

    public function show(Brand $brand)
    {
        $data = ['row' => $brand];
        return view('admin.brands.show')->with($data);
    }

    public function edit(Brand $brand)
    {
        $data = [
            'row'           => $brand,
        ];
        return view('admin.brands.edit')->with($data);
    }

    public function update(Request $request, Brand $brand)
    {

        $request->validate([
            'name.*' => 'required',
            # 'logo' => 'required',
        ]);

        $logo = upload_file($request->file('logo'), 'brands');
        if ($logo) $brand->logo = $logo;

        $brand->save();

        foreach($this->languages as $local){
            $brandTrans = BrandTranslation::where([
                'brand_id' => $brand->id,
                'locale' => $local->locale,
            ])->first();
            if (!$brandTrans) $brandTrans = new BrandTranslation();
            $brandTrans->brand_id = $brand->id;
            $brandTrans->name = $request->input('name.'.$local->locale);

            $brandTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $brandTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $brandTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $brandTrans->locale = $local->locale;
            $brandTrans->save();
        }
        # log the action to database
        $logPayload = ['msg' => 'Brand Updated', 'model_id' => $brand->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.brands.index');

    }

    public function destroy(Brand $brand)
    {
        $brandTrans = BrandTranslation::where('brand_id','=',$brand->id)->delete();
        $brand->delete();
        return redirect()->route('admin.brands.index');
    }

}
