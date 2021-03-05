<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\CategoryTranslation;
use App\Exports\CategoriesExport;
use App\Imports\CategoriesImport;
use App\Language;
use App\Page;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_category');
        $this->middleware('permission:create_category', ['only' => ['create','store']]);
        $this->middleware('permission:edit_category', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_category', ['only' => ['destroy']]);

        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {

    	$query = Category::query();

    	if (\request()->get('category'))
    	    $query->whereParentId(\request()->get('category'));

        $category = $query->get();

        $data = ['rows' => $category];
        return view('admin.categories.index')->with($data);
    }

    public function import() {
        Excel::import(new CategoriesImport,request()->file('file'));
        return back();
    }

    public function export() {
        return Excel::download(new CategoriesExport(), 'categories.xlsx');
    }

    public function create()
    {
        $dbCat = Category::get();
        $categories = [];
        $this->getCategories($dbCat, $categories);

        return view('admin.categories.create', compact('categories'));
    }

    function getCategories($categories, &$result, $parent_id = 0, $depth = 0)
    {
        //filter only categories under current "parent"
        $cats = $categories->filter(function ($item) use ($parent_id) {
            return $item->parent_id == $parent_id;
        });

        //loop through them
        foreach ($cats as $cat)
        {
            //add category. Don't forget the dashes in front. Use ID as index
            $result[$cat->id] = str_repeat('-', $depth) . ($depth ? ' ' : '') . $cat->name;
            //go deeper - let's look for "children" of current category
            $this->getCategories($categories, $result, $cat->id, $depth + 1);
        }
    }


    public function store(Request $request)
    {

        $request->validate([
            'name.*' => 'required',
            'slug.*' => 'required|unique:category_translations,slug',
        ]);
        $category = new Category();
        $category->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $category->in_header = $request->get('in_header') == "on" ? 1 : 0 ;
        $category->parent_id = $request->get('parent_id');
        $category->return_policy = $request->get('return_policy');
        $category->arrange = $request->get('arrange');
        $category->shipping_type = $request->get('shipping_type');
        $category->shipping_value = $request->get('shipping_value');

        $category->icon = upload_file($request->file('icon'), 'categories');
        $category->banner = upload_file($request->file('banner'), 'categories');

        $category->save();
        $check_sub = Category::where('parent_id','=',$category->id)->get();
        foreach($check_sub as $sub){
            if((int)$sub->shipping_type < 1){
                $sub->shipping_type = $request->get('shipping_type');
                $sub->shipping_value = $request->get('shipping_value');
                $sub->save();
            }
        }

        foreach($this->languages as $local){
            $categoryTrans = new CategoryTranslation();
            $categoryTrans->category_id = $category->id;
            $categoryTrans->name = $request->input('name.'.$local->locale);
            $categoryTrans->slug = $request->input('slug.'.$local->locale);
            $categoryTrans->description = $request->input('description.'.$local->locale);

            $categoryTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $categoryTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $categoryTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $categoryTrans->locale = $local->locale;
            $categoryTrans->save();
        }

        # Category::create($request->all());
        $logPayload = ['msg' => 'Category Added', 'model_id' => $category->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.categories.index');

    }

    public function show(Category $category)
    {
        $data = ['row' => $category];
        return view('admin.categories.show')->with($data);
    }


    public function edit(Category $category)
    {

        $dbCat = Category::where('id', '!=', $category->id)->get();
        $categories = [];
        $this->getCategories($dbCat, $categories);

        $data = [
            'row'           => $category,
            'categories'    => $categories,
        ];
        return view('admin.categories.edit')->with($data);
    }

    public function update(Request $request, Category $category)
    {

        $request->validate([
            'name.*' => 'required',
            'slug.*' => 'required',
        ]);

        $category->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $category->in_header = $request->get('in_header') == "on" ? 1 : 0 ;
        $category->parent_id = $request->get('parent_id');
        $category->return_policy = $request->get('return_policy');
        $category->arrange = $request->get('arrange');
        $category->shipping_type = $request->get('shipping_type');
        $category->shipping_value = $request->get('shipping_value');

        $icon = upload_file($request->file('icon'), 'categories');
        if ($icon) $category->icon = $icon;

        $banner = upload_file($request->file('banner'), 'categories');
        if ($banner) $category->banner = $banner;

        $category->save();
        
        $check_sub = Category::where('parent_id','=',$category->id)->get();
        foreach($check_sub as $sub){
            if((int)$sub->shipping_type < 1){
                $sub->shipping_type = $request->get('shipping_type');
                $sub->shipping_value = $request->get('shipping_value');
                $sub->save();
            }
        }

        foreach($this->languages as $local){
            $categoryTrans = CategoryTranslation::where([
                'category_id' => $category->id,
                'locale' => $local->locale,
            ])->first();
            if (!$categoryTrans) $categoryTrans = new CategoryTranslation();
            $categoryTrans->category_id = $category->id;
            $categoryTrans->name = $request->input('name.'.$local->locale);
            $categoryTrans->slug = $request->input('slug.'.$local->locale);
            $categoryTrans->description = $request->input('description.'.$local->locale);

            $categoryTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $categoryTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $categoryTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $categoryTrans->locale = $local->locale;
            $categoryTrans->save();
        }
        $logPayload = ['msg' => 'Category Updated', 'model_id' => $category->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.categories.index');

    }


    public function destroy(Category $category)
    {

        $Products = ProductCategory::whereCategoryId($category->id)->delete();

        // if ($hasProducts) {
        //     return redirect()->route('admin.categories.index')->withErrors('This category has products and can\'t be deleted.');
        // }

        Category::where('parent_id', $category->id)->update([
            'parent_id' => 0
        ]);

        $categoryTrans = CategoryTranslation::where('category_id','=',$category->id)->delete();
        $category->delete();
        return redirect()->route('admin.categories.index');
    }

}
