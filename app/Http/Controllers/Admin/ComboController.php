<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Brand;
use App\BundleProduct;
use App\Category;
use App\Language;
use App\Manufacturer;
use App\ProductCategory;
use App\ProductTranslation;
use App\ComboCategory;
use App\CategoryTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCombo;
use App\Combo;
use App\ComboValue;
use App\Periortysetting;

class ComboController extends Controller
{
    //
    public function __construct()
    {
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.combo.index', compact('products'));
    }

    public function products() {
        $q = \request()->get('q');

        $products = ProductTranslation::where('locale', 'ar')
            ->leftJoin('products', 'products.id', 'product_translations.product_id')
            ->where('products.is_bundle', false)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
                $query->orWhere('product_id', 'like', '%' . $q . '%');
            })
            ->limit(15)
            ->get();
        $results = $products->map(function ($product) {
            return [
                'id'        => $product->product_id,
                'text'      => $product->name,
                'price'     => $product->product->price,
                'before_price'     => $product->product->before_price,
            ];
        });

        return [
            'results' => $results,
//            "pagination": {
//            "more": true
//  }
        ];
    }

    public function categories() {
        $q = \request()->get('q');

        $categories = CategoryTranslation::where('locale', 'ar')
            ->leftJoin('categories', 'categories.id', 'category_translations.category_id')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
                $query->orWhere('category_id', 'like', '%' . $q . '%');
            })
            ->limit(15)
            ->get();
        $results = $categories->map(function ($category) {
            return [
                'id'        => $category->category_id,
                'text'      => $category->name
            ];
        });

        return [
            'results' => $results,
//            "pagination": {
//            "more": true
//  }
        ];
    }

    public function data() {

        $query=Combo::all();
        return datatables()->of($query)
            ->editColumn('name', function (Combo $product) {
                if(app()->getLocale()=='ar'){
                    return $product->name_ar;
                }else{
                    return $product->name_en;
                }
            })
            ->editColumn('is_active', function (Combo $product) {
                return $product->status=='active' ? '<span class="label label-info">Active</span>' : '<span class="label label-danger">Inactive</span>';
            })
            ->addColumn('options', function (Combo $product) {

                $back = "";
                # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
                $back .= '&nbsp;<a href="'. route('admin.combo.edit', $product->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

                $back .= \Form::open(['url'=>route('admin.combo.destroy', $product->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
                $back .= method_field('DELETE');
                $back .= \Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']);
                $back .= \Form::close();

                return $back;
            })
            ->rawColumns(['options', 'name', 'is_active'])
            ->make(true);
    }

    public function create()
    {
        $categories = categories();
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();
        return view('admin.combo.create', compact('categories', 'brands', 'manufacturers'));
    }

    public function store(Request $request)
    {
        $rules = [
            
            'name_ar' => 'required',
            'name_en' => 'required'
                    ];
        $request->validate($rules);

        $data=$request->all();
        //dd($data);
        if(Periortysetting::first()->enable==1){
            $order_id=\App\Periorty::where('name','combo')->first()->order_id;
            foreach($request->products as $i => $id){
                if(!priorty($order_id,$id)){
                    $sub_product=Product::find($id);
                    session()->flash('has_not_periorty','You canot add this offer has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();
                }
            }
        }
        $combo = new Combo();
        $combo->status = $request->get('active') == "on" ? 'active' : 'inactive' ;
        $combo->name_ar = $request->name_ar;
        $combo->name_en = $request->name_en;
        $combo->save();
        
        if ($request->shipping_free='on') {
            $shipping_free=1;
        }else{
            $shipping_free=0;
        }
        if ($request->one_piece_free='on') {
            $one_piece_free=1;
        }else{
            $one_piece_free=0;
        }
        $percentages=$request->percentage;
        foreach ($request->num as $key => $num) {
            $combo_value=new ComboValue();
            $combo_value->num=$num;
            $combo_value->percentage=$percentages[$key];
            $combo_value->combo_id=$combo->id;
            $combo_value->shipping_free=$shipping_free;
            $combo_value->one_piece_free=$one_piece_free;
            $combo_value->save();
        }

        $products=$request->products;
        foreach($request->products as $i => $id){                
                $sub_product=Product::find($id);
                $sub_product->on_sale=0;
                $sub_product->is_hot=0;
                $sub_product->cupons()->sync([]);
                $sub_product->promotions()->sync([]);
                $sub_product->save();
                BundleProduct::where('product_id',$id)->delete();
                ProductCombo::create([
                    'combo_id'=>$combo->id,
                    'product_id'=>$id
                ]);
        }
        
            
        $categories=$request->categories;
        if($request->categories){
            foreach ($categories as $key => $category_id) {
                ComboCategory::create([
                    'combo_id'=>$combo->id,
                    'category_id'=>$category_id
                ]);
                $cat=Category::find($category_id);
                $products2=$cat->products()->get();
                foreach ($products2 as $key => $product) {
                    ProductCombo::create([
                        'combo_id'=>$combo->id,
                        'product_id'=>$product->id
                    ]);
                }
            }
        }

        return redirect()->route('admin.combo.index');
    }

    function getCategoryParents($id, $ids = []) {
        $category = Category::find($id);
        if ($category->parent_id) {
            $ids[] = $category->parent_id;
            return $this->getCategoryParents($category->parent_id, $ids);
        }
        return $ids;
    }

//    public function show($id)
//    {
//        $order = Order::with('products')->findOrFail($id);
//        return view('admin.bundles.show')->with( compact('order') );
//    }

    public function edit($id)
    {
        $product = Combo::find($id);
        $categories_id = ComboCategory::where('combo_id','=',$id)->pluck('category_id')->toArray();
        $categories=Category::whereIn('id',$categories_id)->get();
        //dd($categories);
        
        return view('admin.combo.edit', compact('product','categories'));
    }

    public function update(Request $request, $id)
    {
        $combo = Combo::find($id);
        $cat_ids=$combo->getCategoryIdsAttribute();
        //dd($cat_ids);
        $product_ids=$combo->getProductIdsAttribute();
        $rules = [
            
            'name_ar' => 'required',
            'name_en' => 'required'
                    ];
        $request->validate($rules);
       
        $combo->status = $request->active ? 'active' : 'inactive' ;
        $combo->name_ar = $request->name_ar;
        $combo->name_en = $request->name_en;
        $combo->save();

        $percentages=$request->percentage;
        $one_piece_free=$request->one_piece_free;
        $shipping_free=$request->shipping_free;
        ComboValue::where('combo_id','=',$combo->id)->delete();
        foreach ($request->num as $key => $num) {
            $combo_value=new ComboValue();
            $combo_value->num=$num;
            $combo_value->percentage=$percentages[$key];
            $combo_value->combo_id=$combo->id;
            $combo_value->shipping_free=isset($shipping_free[$key])&&$shipping_free[$key]=='on'?1:0;
            $combo_value->one_piece_free=isset($one_piece_free[$key])&&$one_piece_free[$key]=='on'?1:0;
            $combo_value->save();
        }
        if(Periortysetting::first()->enable==1){
            $order_id=\App\Periorty::where('name','combo')->first()->order_id;
            foreach($request->products as $i => $id){
                if(!priorty($order_id,$id)){
                    $sub_product=Product::find($id);
                    session()->flash('has_not_periorty','You canot add this offer has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();
                }
            }
        }
        //Product combo
        $order_id=\App\Periorty::where('name','combo')->first()->order_id;
        $products=$request->products;
        //dd($products);
        if($request->products){
            foreach($request->products as $i => $id){
                if (in_array($id, $product_ids)) {
                        continue;
                }
                $sub_product=Product::find($id);
                $sub_product->on_sale=0;
                $sub_product->is_hot=0;
                $sub_product->cupons()->sync([]);
                $sub_product->promotions()->sync([]);
                $sub_product->save();
                BundleProduct::where('product_id',$id)->delete();
                ProductCombo::create([
                    'combo_id'=>$combo->id,
                    'product_id'=>$id
                ]);
                
            }
        }
        // if($request->products){
        //     foreach ($products as $product_id) {
        //         if (in_array($product_id, $product_ids)) {
        //             continue;
        //         }
        //         ProductCombo::create([
        //             'combo_id'=>$combo->id,
        //             'product_id'=>$product_id
        //         ]);
        //     }
        // }
        $deleted_products=array_diff($product_ids,$products);
        ProductCombo::whereIn('product_id',$deleted_products)->delete();

        //Category Combo
        if($request->has('categories')){
            $categories=$request->categories;
            foreach ($categories as $key => $category_id) {
                if (in_array($category_id, $cat_ids)) {
                    continue;
                }
                ComboCategory::create([
                    'combo_id'=>$combo->id,
                    'category_id'=>$category_id
                ]);
                $cat=Category::find($category_id);
                $products2=$cat->products()->get();
                foreach ($products2 as $key => $product) {
                    ProductCombo::create([
                        'combo_id'=>$combo->id,
                        'product_id'=>$product->id
                    ]);
                }
            }
            foreach ($cat_ids as $id) {
                $cat=Category::find($id);
                if (!in_array($id,$categories)) {
                    ProductCombo::whereNotIn('product_id',$products)->whereIn('product_id',$cat->getProductIdsAttribute())->delete();
                    ComboCategory::where('category_id','=',$id)->delete();
                }
            }
        }else{

            ComboCategory::where('combo_id','=',$combo->id)->delete();
            foreach ($cat_ids as $id) {
                $cat=Category::find($id);
                ProductCombo::whereNotIn('product_id',$products)->whereIn('product_id',$cat->getProductIdsAttribute())->delete();
            }
        }
        // $deleted_cats=array_diff($cat_ids,$categories);
        // dd($deleted_cats);
        // ComboCategory::whereIn('category_id',$deleted_cats)->delete();
        //return back();
        return redirect()->route('admin.combo.index');
    }

    public function destroy($id)
    {
        $product = Combo::find($id);
        ComboValue::where('combo_id', $product->id)->delete();
        $product->delete();
        return redirect()->route('admin.combo.index');
    }
}
