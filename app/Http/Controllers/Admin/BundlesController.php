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
use App\Periortysetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\AttributeProduct;

class BundlesController extends Controller
{

    public function __construct()
    {
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.bundles.index', compact('products'));
    }

    public function products() {
        $category = Category::where('id',\request('category_id'))->first();
        $products = $category->products;
        $ids = collect();
        foreach ($products as $product){
            $ids->push($product->id);
        }




        $products = ProductTranslation::where('locale', 'ar')
            ->leftJoin('products', 'products.id', 'product_translations.product_id')
            ->where('products.is_bundle',false)
            ->whereIn('products.id',$ids)
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

    public function data() {

        // $isOrder = \request()->get('order');

        // if ($isOrder) $query = Product::query();
        // else $query = Product::query()->orderBy('id','desc')->limit(10);
        // $query = Product::orderBy('id','desc')->limit(10);

        // $query->select('products.*', 'product_translations.name');

        // $query->leftJoin('product_translations', 'products.id', 'product_translations.product_id');
        // $query->where('product_translations.locale', 'ar');
        // $query->where('products.is_bundle', true);

        // if (\request()->get('brand')) {
        //     $query->where('brand_id', \request()->get('brand'));
        // }

        // if (\request()->get('manufacturer')) {
        //     $query->where('manufacturer_id', \request()->get('manufacturer'));
        // }

        // if (\request()->get('category')) {
        //     $query
        //         ->join('product_categories', 'product_categories.product_id', 'products.id')
        //         ->where('category_id', \request()->get('category'));
        // }
        $bundles=Product::where('is_bundle',true);
        return datatables()->of($bundles)
            ->editColumn('product_translations.name', function (Product $product) {
                return $product->name . '<br />' . ($product->categories[0]->name ?? '');
            })
            ->editColumn('brand_manufacturer', function (Product $product) {
                return ($product->brand->name ?? '') . '<br />' . ($product->manufacturer->name ?? '');
            })
            ->editColumn('bundle_start', function (Product $product) {
                return $product->bundle_start;
            })
            ->editColumn('bundle_end', function (Product $product) {
                return $product->bundle_end;
            })
            ->editColumn('is_active', function (Product $product) {
                return $product->is_active ? '<span class="label label-info">Active</span>' : '<span class="label label-danger">Inactive</span>';
            })

            ->addColumn('options', function (Product $product) {

                $back = "";
                # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
                $back .= '&nbsp;<a href="'. route('admin.bundles.edit', $product->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';
                if($product->is_active == 0){
                    $back .= '&nbsp;<a href="'. route('admin.bundles.active', $product->id) .'" class="btn waves-effect waves-light btn-outline-success" title="active">Activate</a>&nbsp;';
                }else{
                    $back .= '&nbsp;<a href="'. route('admin.bundles.active', $product->id) .'" class="btn waves-effect waves-light btn-outline-danger" title="inactive">InActivate</a>&nbsp;';
                }


                $back .= \Form::open(['url'=>route('admin.bundles.destroy', $product->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
                $back .= method_field('DELETE');
                $back .= \Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']);
                $back .= \Form::close();

                return $back;
            })
            ->rawColumns(['options', 'brand_manufacturer', 'product_translations.name', 'is_active'])
            ->make(true);
    }

    public function create()
    {

        $categories = categories();
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();
        return view('admin.bundles.create', compact('categories', 'brands', 'manufacturers'));
    }

    public function store(Request $request)
    {
        $productsRuinedQuantity = BundleProduct::checkQuantity($request);
        if($productsRuinedQuantity){
            return back()->with('message',$productsRuinedQuantity);
        };

        $product = [];
        $product['is_active'] = $request->get('active') == 1 ? 1 : 0 ;
        // $product->brand_id = $request->get('brand_id');
        // $product->manufacturer_id = $request->get('manufacturer_id');
        $product=$request->except('_token');
        $product['return_allowed'] = 0;
        $product['return_duration'] = 0;
        $product['price'] = $request->get('price');
        // $product['stock'] = 0;
        // $product['minimum_stock'] = 0;
        // $product['on_sale'] = 0;
        $product['is_bundle'] = 1;
        $product['stock'] = 1;
        $product['before_price'] = $request->get('before_price') ?? 0;
        $product['bundle_start'] = $request->get('bundle_start');
        $product['bundle_end'] = $request->get('bundle_end');

        $validation_conditions=[];
        if (!isset($request->products) || count($request->products)<2  ) {
            $validation_conditions[0]='Product Should be More than one Product';
            //return back()->with('error_products','Product Should be More than one Product');
        }
        if ( strtotime($request->get('bundle_start')) >  strtotime($request->get('bundle_end')) ) {
            $validation_conditions[1]='End Date Can\'t be earlier than the start date';
        }
        if(count($validation_conditions) > 0 ){
            return back()->with('validation_conditions',$validation_conditions);
        }
        //dd($product->{'name:en'});
        // foreach($this->languages as $local){
        //     $productTrans = new ProductTranslation();
        //     $productTrans->product_id = $product->id;
        //     $productTrans->name = $request->input('name.'.$local->locale);
        //     $productTrans->locale = $local->locale;
        //     $productTrans->save();
        // }
        if(Periortysetting::first()->enable==1){
            $order_id=\App\Periorty::where('name','bundle')->first()->order_id;
            foreach($request->products as $i => $id){
                if(!priorty($order_id,$id)){
                    $sub_product=Product::find($id);
                    session()->flash('has_not_periorty','You canot add this offer has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();
                }
            }
        }
        $image = upload_file($request->file('bundle_image'), 'products');
        if ($image) $product['bundle_image'] = $image;

        $product=Product::create($product);

        foreach($this->languages as $local){
            $productTrans = new ProductTranslation();
            $productTrans->product_id = $product->id;
            $productTrans->name = $request->input('name.'.$local->locale);
            $productTrans->slug = trim(str_replace(' ',"-",$request->input('slug.'.$local->locale)));
            $productTrans->description = $request->input('description.'.$local->locale);
            $productTrans->locale = $local->locale;
            $productTrans->product_id = $product->id;
            $productTrans->save();
        }

        foreach($request->products as $i => $id){
                //$x++;
                $bundle_product = new BundleProduct();
                $bundle_product->bundle_id = $product->id;
                $bundle_product->product_id = $id;
                $bundle_product->quantity = $request->quantity[$i];
                $bundle_product->discount = $request->discount[$i];
                $bundle_product->save();
                // \App\ProductCombo::where('product_id',$id)->delete();
                // $sub_product=Product::find($id);
                // $sub_product->on_sale=0;
                // $sub_product->is_hot=0;
                // $sub_product->cupons()->sync([]);
                // $sub_product->promotions()->sync([]);
                // $sub_product->save();
        }


        $categoryParents = $this->getCategoryParents($request->get('category_id'), [(int)$request->get('category_id')]);

        ProductCategory::where('product_id', $product->id)->delete();

        foreach ($categoryParents as $cat) {
            ProductCategory::insert([
                'product_id' => $product->id,
                'category_id' => $cat,
            ]);
        }


        # log the action to database
        $logPayload = ['msg' => 'Bundle Added', 'model_id' => $product->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.bundles.index');
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
        $product = Product::findOrFail($id);

        $categories = categories();
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();
        $bundle = new BundleProduct();
        $price = $bundle->getPrice($id); // get the new price for the bundle
        $old_price = $bundle->getTotalOldPrice($id); // get the old prices of all the products sharing the bundle
        $bundles = BundleProduct::where('bundle_id', $id)->get();




        return view('admin.bundles.edit', compact('product', 'categories', 'brands', 'manufacturers', 'bundles', 'old_price','price'));
    }

    public function update(Request $request, $id)
    {
        $productsRuinedQuantity = BundleProduct::checkQuantity($request);
        if($productsRuinedQuantity){
            return back()->with('message',$productsRuinedQuantity);
        };



        $product = Product::findOrfail($id);
        if ($request->get('price') < 0){
            return back()->with('message', 'Price can not be Negative');
        }
        if (strtotime($request->get('bundle_start')) >  strtotime($request->get('bundle_end')))
            return back()->with(['message'=>'End Date Can\'t be earlier than the start date']);
        //dd($request->all());
        $product->is_active = $request->get('active') == "1" ? 1 : 0 ;
        // $product->brand_id = $request->get('brand_id');
        // $product->manufacturer_id = $request->get('manufacturer_id');
        $product->return_allowed = 0;
        $product->return_duration = 0;
        $product->price = $request->get('price');
        $product->stock = 0;
        $product->minimum_stock = 0;
        $product->on_sale = 1;
        $product->is_bundle = true;
        $product->before_price = $request->get('before_price') ?? 0;
        $product->bundle_start = $request->get('bundle_start');
        $product->bundle_end = $request->get('bundle_end');
        #Bundle Image
        $image = upload_file($request->file('bundle_image'), 'products');
        if ($image) $product['bundle_image'] = $image;

        $product->save();

        BundleProduct::where('bundle_id', $product->id)->delete();

        if(Periortysetting::first()->enable==1){
            $order_id=\App\Periorty::where('name','bundle')->first()->order_id;
            foreach($request->products as $i => $id){
                if(!priorty($order_id,$id)){
                    $sub_product=Product::find($id);
                    session()->flash('has_not_periorty','You canot add this offer "Bundle" has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();
                }
            }
        }


        foreach($request->products as $i => $id){

                $bundle_product = new BundleProduct();
                $bundle_product->bundle_id = $product->id;
                $bundle_product->product_id = $id;
                $bundle_product->quantity = $request->quantity[$i];
                $bundle_product->discount = $request->discount[$i];
                $bundle_product->save();
                \App\ProductCombo::where('product_id',$id)->delete();
                $sub_product=Product::find($id);
                $sub_product->on_sale=0;
                $sub_product->is_hot=0;
                $sub_product->save();
        }

        // foreach ($request->products as $i => $id) {
        //     $bundle_product = new BundleProduct();
        //     $bundle_product->bundle_id = $product->id;
        //     $bundle_product->product_id = $id;
        //     $bundle_product->quantity = $request->quantity[$i];
        //     $bundle_product->discount = $request->discount[$i];
        //     $bundle_product->save();
        // }


        $categoryParents = $this->getCategoryParents($request->get('category_id'), [(int)$request->get('category_id')]);

        ProductCategory::where('product_id', $product->id)->delete();

        foreach ($categoryParents as $cat) {
            ProductCategory::insert([
                'product_id' => $product->id,
                'category_id' => $cat,
            ]);
        }

        foreach($this->languages as $local){
            $productTrans = ProductTranslation::where([
                'product_id' => $product->id,
                'locale' => $local->locale,
            ])->first();
            if (!$productTrans) $productTrans = new ProductTranslation();
            $productTrans->product_id = $product->id;
            $productTrans->name = $request->input('name.'.$local->locale);
            $productTrans->slug = $request->input('slug.'.$local->locale);
            $productTrans->description = $request->input('description.'.$local->locale);
            $productTrans->locale = $local->locale;
            $productTrans->save();
        }
        # log the action to database
        $logPayload = ['msg' => 'Bundle Updated', 'model_id' => $product->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.bundles.index');
    }

    public function activation($id)
    {
        $product = Product::find($id);
        $product->is_active? $product->is_active=0 : $product->is_active=1;
        $product->save();
        return redirect()->route('admin.bundles.index');
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        ProductCategory::where('product_id', $product->id)->delete();
        ProductTranslation::where('product_id', $product->id)->delete();
        BundleProduct::where('bundle_id', $product->id)->delete();
        AttributeProduct::where('product_id', $product->id)->delete();
        $product->delete();

        return redirect()->route('admin.bundles.index');
    }
}
