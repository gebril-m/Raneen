<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Category;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Manufacturer;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use App\ProductTranslation;
use App\Language;
use App\Page;
use App\Attribute;
use App\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;
use App\Combo;
use App\BundleProduct;
use App\ProductCombo;
use App\AttributeCategory;
use App\AttributeProduct;
use App\User;
use App\Periortysetting;
use Hash;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_product');
        $this->middleware('permission:create_product', ['only' => ['create','store']]);
        $this->middleware('permission:edit_product', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_product', ['only' => ['destroy']]);

        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();

        $categories = categories();
        return view('admin.products.index', compact('brands', 'manufacturers', 'categories'));
    }

    public function export() {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }

    public function importShow()
    {
        $categories = categories();
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();

        return view('admin.products.import', compact('categories', 'brands', 'manufacturers'));
    }
    public function findone($id){
        return Product::find($id);
    }
    public function data($kind='') {

        $isOrder = \request()->get('order');

        if ($isOrder) $query = Product::query();
        else $query = Product::query()->orderBy('id','desc')->limit(10);

        $query->select('products.*', 'product_translations.name');

        $query->leftJoin('product_translations', 'products.id', 'product_translations.product_id');
        $query->where('product_translations.locale', 'ar');
        $query->where('products.is_bundle', false);
        $query->where('products.is_combo', false);

        if ($kind != '' || $kind=\request()->get('kind')) {
            if ($kind=='on_sale') {
                $query->where('on_sale', 1);
            }
            if ($kind=='is_hot') {
                $query->where('is_hot', 1);
            }
            if ($kind=='is_combo') {
                $combo_ids=ProductCombo::pluck('product_id')->toArray();

                $query->whereIn('products.id', $combo_ids);
            }
        }

        if (\request()->get('brand')) {
            $query->where('brand_id', \request()->get('brand'));
        }

        if (\request()->get('manufacturer')) {
            $query->where('manufacturer_id', \request()->get('manufacturer'));
        }

        if (\request()->get('category')) {
            $query
                ->join('product_categories', 'product_categories.product_id', 'products.id')
                ->where('category_id', \request()->get('category'));
        }

        return datatables()->of($query)
            ->editColumn('product_translations.name', function (Product $product) {
                return $product->name . '<br />' . ($product->categories[0]->name ?? '');
            })
            ->editColumn('brand_manufacturer', function (Product $product) {
                return ($product->brand->name ?? '') . '<br />' . ($product->manufacturer->name ?? '');
            })
            ->editColumn('is_active', function (Product $product) {
                return $product->is_active ? '<span class="label label-info">Active</span>' : '<span class="label label-danger">Inactive</span>';
            })
            ->editColumn('item_no', function (Product $product) {
                return $product->item_id;
            })
            ->addColumn('price', function (Product $product) {
                if($product->on_sale == 1){
                    return $product->before_price;
                }else if($product->is_hot == 1){
                    return $product->price;
                }else{
                    return $product->price;
                }
            })

            ->addColumn('discount', function (Product $product) {
                if($product->on_sale == 1 || $product->is_hot == 1){
                    if($product->on_sale == 1){
                        return "Price After: ".$product->price;
                    }
                    if($product->is_hot == 1){
                        return "Price After: ".$product->hot_price." - "."(Starts ".$product->hot_starts_at." - "."Ends ".$product->hot_ends_at.")";
                    }
                }else{
                    return "No Discount";
                }
                return $product->on_sale == 1 ? '<span class="label label-info">Active</span>' : '<span class="label label-danger">Inactive</span>';
            })
            ->addColumn('hot_price', function (Product $product) {
                return $product->hot_price;
            })
            ->addColumn('before_price', function (Product $product) {
                return $product->before_price;
            })
            ->addColumn('stock', function (Product $product) {
                return $product->stock;
            })
            ->addColumn('options', function (Product $product) {

                $back = "";
                $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
                $back .= '&nbsp;<a href="'. route('admin.products.edit', $product->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';
                $back .= \Form::open(['url'=>route('admin.products.destroy', $product->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
                if($product->on_sale == 1 || $product->is_hot == 1){
                    $back .= '&nbsp;<a href="'. route('admin.products.enddeal', $product->id) .'" class="btn waves-effect waves-light btn-outline-info" title="End Deal">End Deal</a>&nbsp;';
                }
                if($product->is_active == 0){
                    $back .= '&nbsp;<a href="'. route('admin.products.active', $product->id) .'" class="btn waves-effect waves-light btn-outline-success" title="active">Activate</a>&nbsp;';
                }else{
                    $back .= '&nbsp;<a href="'. route('admin.products.active', $product->id) .'" class="btn waves-effect waves-light btn-outline-danger" title="inactive">InActivate</a>&nbsp;';
                }
                $back .= method_field('DELETE');
                $back .= \Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']);
                $back .= \Form::close();

                return $back;
            })
            ->rawColumns(['options', 'brand_manufacturer', 'product_translations.name', 'is_active'])
            ->make(true);
    }

    public function activation($id)
    {
        $product = Product::find($id);
        $product->is_active? $product->is_active=0 : $product->is_active=1;
        $product->save();
        return redirect()->route('admin.products.index');
    }

    public function create()
    {
        $categories = categories();
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();
        $combos=Combo::all();
        $pattributes = Attribute::with('childrensRow')->parents()->get();
        return view('admin.products.create', compact('categories', 'brands', 'manufacturers', 'pattributes','combos'));
    }

    function getProductAttributes(Request $request, Product $product){
        $id = $request->input('id');
        $attributes = $product::with('attributes')->find($id)
                    ->attributes
                    ->pluck('name', 'id')
                    ->unique();
        return view('admin.attributes.product_attributes')->with(compact('attributes'));
    }
    function getProductAttributesAjax(Request $request, Product $product){
        $ids = $request->input('ids');
        $attributesIds = AttributeCategory::where('category_id','=',$ids)->pluck('attribute_id')->toArray();
        //dd($attributesIds);
        $attributes=Attribute::whereIn('id',$attributesIds)->get();

         //dd($attributes);
        return view('admin.attributes.product_attributes')->with(compact('attributes'));
    }

    function getCurrentProductAttributesAjax(Request $request, Product $product){
        $ids = $request->input('ids');
        $attributesIds = AttributeCategory::where('category_id','=',$ids)->pluck('attribute_id')->toArray();
        //dd($attributesIds);
        $attributes=Attribute::whereIn('id',$attributesIds)->get();

         //dd($attributes);
        return view('admin.attributes.current_product_attributes')->with(compact('attributes'));
    }

    function getCategoryParents($id, $ids = []) {
        $category = Category::find($id);
        if ($category->parent_id) {
            $ids[] = $category->parent_id;
            return $this->getCategoryParents($category->parent_id, $ids);
        }
        return $ids;
    }

    public function store(Request $request)
    {
        //dd($request->combo_id);
        $request->validate([
            'name.*'            => 'required',
            'description.*'     => 'required',
            'stock'            => 'gte:minimum_stock',
        ]);

        $product = new Product();
        $product->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $product->is_point = $request->get('point') == "on" ? 1 : 0 ;
        $product->brand_id = $request->get('brand_id');
        $product->manufacturer_id = $request->get('manufacturer_id');
        $product->return_allowed = $request->get('return_allowed') == "on" ? 1 : 0 ;
        $product->return_duration = $request->get('return_duration') ?? 0;
        $product->price = $request->get('price');
        $product->stock = $request->get('stock') ?? 0;
        $product->minimum_stock = $request->get('minimum_stock');
        $product->on_sale = $request->get('on_sale') == "on" ? 1 : 0 ;
        $product->barcode = $request->get('barcode');
        $product->item_id = $request->get('item_id');
        $product->axapta_code = $request->get('axapta_code');
        $product->weight = $request->get('weight');
        $product->length = $request->get('length');
        $product->width = $request->get('width');
        $product->height = $request->get('height');
        $product->reward_points = $request->get('reward_points');
        if($request->sale_ends_at)
            $product->sale_ends_at = Carbon::createFromFormat('Y/m/d H:i', $request->get('sale_ends_at'))->toDateTimeString();
        else
            $product->sale_ends_at = null;


        $product->is_hot = $request->get('is_hot') == "on" ? 1 : 0 ;
        $product->before_price = $request->get('before_price') ?? 0;
        $product->hot_price = $request->get('hot_price') ?? 0;

        if ($product->on_sale) {
            $product->price = $product->before_price;
            $product->before_price = $request->get('price');
        }

        if($product->is_hot)
        {
            $product->price     = $product->hot_price;
            $product->hot_price = $request->get('price');
            if ($request->get('hot_starts_at'))
                $product->hot_starts_at = Carbon::createFromFormat('Y/m/d H:i', $request->get('hot_starts_at'))->toDateTimeString() ?? null;
            if ($request->get('hot_ends_at'))
                $product->hot_ends_at = Carbon::createFromFormat('Y/m/d H:i', $request->get('hot_ends_at'))->toDateTimeString() ?? null;
        }

        $product->save();

        if ($request->combo_id) {
            foreach($request->combo_id as $combo_id)
            {
                ProductCombo::create([
                    'product_id'=>$product->id,
                    'combo_id'=>$combo_id,
                ]);
            }
        }

        $gallery = [];
        if (\request()->hasFile('images')) {
            foreach (\request()->file('images') as $x => $image) {
                if($image->isValid()) {
                    $gallery[] = [
                        'image' => upload_file($image, 'products'),
                        'thumb' => $request->input('thumbnail.' . $x),
                    ];
                }
            }
        }

        $thumb = null;
        foreach ($gallery as $item) {
            $productImage = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->image = $item['image'];
            $productImage->save();

            if (!$thumb || $item['thumb'])
                $thumb = $productImage->image;
        }

        $product->thumbnail = $thumb;
        $product->save();

        $categoryParents = $this->getCategoryParents($request->get('category_id'), [(int)$request->get('category_id')]);

        ProductCategory::where('product_id', $product->id)->delete();

        foreach ($categoryParents as $cat) {
            ProductCategory::insert([
                'product_id' => $product->id,
                'category_id' => $cat,
            ]);
        }

        foreach($this->languages as $local){
            $productTrans = new ProductTranslation();
            $productTrans->product_id = $product->id;
            $productTrans->name = $request->input('name.'.$local->locale);
            $productTrans->slug = trim(str_replace(' ',"-",$request->input('name.'.$local->locale)));
            $productTrans->description = $request->input('description.'.$local->locale);
            $productTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $productTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $productTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $productTrans->locale = $local->locale;
            $productTrans->save();
        }

        # assign attributes to product
        // Arrays
        $attributesValues = [];
        $attributesPrices = [];
        $attributesCodes = [];
        $attributesPictures = [];
        // Data
        $attributes = $request->get('product_attributes');
        $attributes_prices = $request->get('attribute_prices');
        $attribute_codes = $request->get('attribute_codes');
        $attribute_pictures = $request->file('attribute_pictures');
        $attribute_values= $request->get('attribute_values');

        if(isset($attributes)) {

            $i = 0;
            foreach($request->get('product_attributes') as $v){
                if(isset($request->file('attribute_pictures')[$i]) && $request->file('attribute_pictures')[$i] != ''){

                    //dd($request->file('attribute_pictures'));
                    $attribute_images=[];
                    for ($x = 0; $x < count($request->file('attribute_pictures')[$i]); $x++) {
                        $file = $request->file('attribute_pictures')[$i][$x];
                        $filename = 'pai_' . str_random(5) . '.' . $file->getClientOriginalName();
                        $destinationPath = public_path('upload/products/');
                        $file->move($destinationPath, $filename);
                        $attribute_images[] = $filename;
                    }

                    $product_attribute_image=json_encode($attribute_images);

                    if(isset($product_attribute_image)){
                        $attributesValues[] = ['quantity' => $attribute_values[$i][0], 'price' => $attributes_prices[$i][0], 'code' => $attribute_codes[$i][0], 'picture' => $product_attribute_image ,'attribute_id'=>$attributes[$i][0] ];
                    }else{
                        $attributesValues[] = ['quantity' => $attribute_values[$i][0], 'price' => $attributes_prices[$i][0], 'code' => $attribute_codes[$i][0] ,'attribute_id'=>$attributes[$i][0]];
                    }

                }

                $i++;
            }
               //dd($attributesValues);
           // $attributesValues = array_combine($attributes, $attributesValues);
            $product->attributes()->sync($attributesValues);


        }

        $logPayload = ['msg' => 'Product Added', 'model_id' => $product->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        # assign options to product
        return redirect()->route('admin.products.index');

    }

    public function show(Product $product)
    {
        $categories = categories();

        $brands = Brand::all();
        $manufacturers = Manufacturer::all();
        $attributes = Attribute::all();
        $combos=Combo::all();

        $data = [
            'row'           => $product,
            'categories'    => $categories,
            'brands'    => $brands,
            'manufacturers'    => $manufacturers,
            'attributes' => $attributes,
            'combos' => $combos
        ];

        return view('admin.products.show')->with($data);
    }


    public function edit(Product $product)
    {

        $categories = categories();

        $brands = Brand::all();
        $manufacturers = Manufacturer::all();
        $attributes = Attribute::all();
        $combos=Combo::all();

        $data = [
            'row'           => $product,
            'categories'    => $categories,
            'brands'    => $brands,
            'manufacturers'    => $manufacturers,
            'attributes' => $attributes,
            'combos' => $combos
        ];

        return view('admin.products.edit')->with($data);
    }

    public function import() {
        Excel::import(new ProductsImport,request()->file('file'));
        return redirect('/big-boss/products');
    }

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name.*'            => 'required',
            'description.*'     => 'required',
        ]);

        $product->is_active = $request->get('active') == "on" ? 1 : 0 ;
        $product->is_point = $request->get('point') == "on" ? 1 : 0 ;
        $product->brand_id = $request->get('brand_id');
        $product->manufacturer_id = $request->get('manufacturer_id');
        $product->return_allowed = $request->get('return_allowed') == "on" ? 1 : 0 ;
        $product->return_duration = $request->get('return_duration') ?? 0;
        $product->price = $request->get('price');
        $product->stock = $request->get('stock') ?? 0;
        $product->minimum_stock = $request->get('minimum_stock');
        $product->on_sale = $request->get('on_sale') == "on" ? 1 : 0 ;
        $product->is_hot = $request->get('is_hot') == "on" ? 1 : 0 ;
        $product->before_price = $request->get('before_price') ?? 0;
        $product->hot_price = $request->get('hot_price') ?? 0;
        $product->reward_points = $request->get('reward_points');

        if ($product->on_sale) {
            if(Periortysetting::first()->enable==1){
                $order_id=\App\Periorty::where('name','on_sale')->first()->order_id;
                if(!priorty($order_id,$product->id)){
                    $sub_product=Product::find($product->id);
                    session()->flash('has_not_periorty','You canot add this offer "On Sale" has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();
                }

            }
            $sub_product=Product::find($product->id);
            $sub_product->is_hot=0;
            $sub_product->cupons()->sync([]);
            $sub_product->promotions()->sync([]);
            $sub_product->save();
            BundleProduct::where('product_id',$product->id)->delete();
            ProductCombo::where('product_id',$product->id)->delete();
            $product->price = $product->before_price;
            $product->before_price = $request->get('price');
        }

        if($product->is_hot)
        {
            // $product->price     = $product->hot_price;
            // $product->hot_price = $request->get('price');
            if(Periortysetting::first()->enable==1){
                $order_id=\App\Periorty::where('name','hot')->first()->order_id;
                if(!priorty($order_id,$product->id)){
                    $sub_product=Product::find($product->id);
                    session()->flash('has_not_periorty','You canot add this offer "Hot" has priorty low with product "' . $sub_product->{'name:en'} .'"');
                    return back();


                }
            }

            if ($request->get('hot_starts_at'))
                $product->hot_starts_at = $request->get('hot_starts_at');
            if ($request->get('hot_ends_at'))
                $product->hot_ends_at = $request->get('hot_ends_at');

            $sub_product=Product::find($product->id);
            $sub_product->on_sale=0;
            $sub_product->cupons()->sync([]);
            $sub_product->promotions()->sync([]);
            $sub_product->save();
            BundleProduct::where('product_id',$product->id)->delete();
            ProductCombo::where('product_id',$product->id)->delete();
        }

        $product->barcode = $request->get('barcode');
        $product->item_id = $request->get('item_id');
        $product->axapta_code = $request->get('axapta_code');
        $product->weight = $request->get('weight');
        $product->length = $request->get('length');
        $product->width = $request->get('width');
        $product->height = $request->get('height');
        $product->save();
        //dd($product->getComboIdsAttribute());
        if ($request->combo_id) {
            ProductCombo::where('product_id',$product->id)->delete();
            foreach($request->combo_id as $combo_id)
            {
                ProductCombo::create([
                    'product_id'=>$product->id,
                    'combo_id'=>$combo_id,
                ]);
            }
        }

        $gallery = [];
        $gids = [];
        if($request->has('images~')) {
            $gids = array_values($request->get('images~'));
        }

        if (\request()->hasFile('images')) {
            foreach (\request()->file('images') as $x => $image) {
                if($image->isValid()) {
                    $gallery[] = [
                        'image' => upload_file($image, 'products'),
                        'thumb' => $request->input('thumbnail.' . $x),
                    ];
                }
            }
        }

        ProductImage::where('product_id', $product->id)->whereNotIn('id', $gids)->delete();

        $thumb = null;
        foreach ($gallery as $item) {
            $productImage = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->image = $item['image'];
            $productImage->save();

            if (!$thumb || $item['thumb'])
                $thumb = $productImage->image;
        }

        $product->thumbnail = $thumb;
        $product->save();

        ProductCategory::where('product_id', $product->id)->delete();
        $categoryParents = $this->getCategoryParents($request->get('category_id'), [(int)$request->get('category_id')]);

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
            $productTrans->slug = trim(str_replace(' ',"-",$request->input('name.'.$local->locale)));
            $productTrans->description = $request->input('description.'.$local->locale);
            $productTrans->meta_title = $request->input('meta_title.'.$local->locale);
            $productTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            $productTrans->meta_description = $request->input('meta_description.'.$local->locale);
            $productTrans->locale = $local->locale;
            $productTrans->save();
        }
        # edit attribute values for product

        # assign attributes to product
        // Arrays


        $attributesValues = [];
        $attributesPrices = [];
        $attributesCodes = [];
        $attributesPictures = [];
        // Data
        $attributes = $request->get('product_attributes');
        $attributes_prices = $request->get('attribute_prices');
        $attribute_codes = $request->get('attribute_codes');
        $attribute_pictures = $request->file('attribute_pictures');
        $attribute_values= $request->get('attribute_values');
        $attribute_old_pictures=$request->get('attribute_old_pictures');
        //dd($attributes);
        if(isset($attributes) ) {

            if(isset($attribute_pictures) ) {
               //dd($attributes);
            $i = 0;
            foreach($request->get('product_attributes') as $v){


                if(isset($request->file('attribute_pictures')[$i]) && $request->file('attribute_pictures')[$i] != ''){

                    //dd($request->file('attribute_pictures'));
                    $attribute_images=[];
                    for ($x = 0; $x < count($request->file('attribute_pictures')[$i]); $x++) {
                        $file = $request->file('attribute_pictures')[$i][$x];
                        $filename = 'pai_' . str_random(5) . '.' . $file->getClientOriginalName();
                        $destinationPath = public_path('upload/products/');
                        $file->move($destinationPath, $filename);
                        $attribute_images[] = $filename;
                    }

                    $product_attribute_image=json_encode($attribute_images);

                    if(isset($product_attribute_image)){
                        $attributesValues[] = ['quantity' => $attribute_values[$i][0], 'price' => $attributes_prices[$i][0], 'code' => $attribute_codes[$i][0], 'picture' => $product_attribute_image ,'attribute_id'=>$attributes[$i][0] ];
                    }else{
                        $attributesValues[] = ['quantity' => $attribute_values[$i][0], 'price' => $attributes_prices[$i][0], 'code' => $attribute_codes[$i][0] ,'attribute_id'=>$attributes[$i][0]];
                    }

                }

                $i++;
            }
               //dd($attributesValues);
           // $attributesValues = array_combine($attributes, $attributesValues);
            $product->attributes()->sync($attributesValues);
          }

        }
        //dd($product->id);
        $logPayload = ['msg' => 'Product Updated', 'model_id' => $product->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.products.index');

    }

    public function destroy(Product $product)
    {
        $productTrans = ProductTranslation::where('product_id','=',$product->id)->delete();
        $productTrans = ProductTranslation::where('product_id','=',$product->id)->delete();
        $product_rel = ProductCategory::where('product_id','=',$product->id)->delete();
        $product_attribute = AttributeProduct::where('product_id','=',$product->id)->delete();
        $product->delete();
        return redirect()->route('admin.products.index');
    }
    public function enddeal(Product $product, $id)
    {
        $product = Product::find($id);
        $product->on_sale = 0;
        $product->is_hot = 0;
        $product->price = $product->before_price;
        $product->before_price = 0;
        $product->save();
        return redirect()->route('admin.products.index');
    }

    /*
        On Sale - Hot - Compo
    */
    // On Sale
    public function onSale()
    {
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();

        $categories = categories();

        return view('admin.products.onsale', compact('brands', 'manufacturers', 'categories'));
    }

    public function onHot()
    {
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();

        $categories = categories();

        return view('admin.products.hot', compact('brands', 'manufacturers', 'categories'));
    }
    // Combo Products
    public function comboProducts()
    {
        $brands = Brand::all();
        $manufacturers = Manufacturer::all();

        $categories = categories();

        return view('admin.products.combo', compact('brands', 'manufacturers', 'categories'));
    }


}
