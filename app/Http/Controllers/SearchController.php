<?php

namespace App\Http\Controllers;

use App\Page;
use App\Http\Controllers\Api\V1\ProductsSearchApiController as psc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
Use View;
use App\ProductCategory;
use App\CategoryTranslation;
use App\Category;
use App\ProductTranslation;
use App\BrandTranslation;
use App\ManufacturerTranslation;
use App\Product;
use Illuminate\Pipeline\Pipeline;
use App\Brand;
use App\Manufacturer;
use App\Attribute;
use App\AttributeProduct;
use App\DealSectionTranslation;
use App\DealSection;
class SearchController extends Controller
{
    public function __construct()
    {
        $locale = App::getLocale();
        View::share('key', 'value');
        View::share('locale',$locale);
    }
    public function index(Request $request){
        $specials = $request->get('specials');
        $search = $request->get('search');
        $attrs_groups = [];
        $attrs = [];

        $products_obj = [];
        $brands_obj = [];
        $manufacturers_obj = [];
        $prices_obj = [];
        $all_array = [];
        if($specials){
            $all_products = Product::where('is_active','=',1)->Where('on_sale','=',1)
            ->orWhere('is_hot','=',1)->where('is_active','=',1)
            ->orWhere('is_bundle','=',1)->where('is_active','=',1)
            ->orWhere('is_combo','=',1)->where('is_active','=',1)
            ->orderBy('price','asc')->get();
            foreach($all_products as $all_product){
                array_push($all_array, $all_product->id);
                array_push($products_obj, $all_product->id);
            }
        }else{
            $all_products = ProductTranslation::where('name','LIKE','%'.$search.'%')->orderBy('id','desc')->get();
            foreach($all_products as $all_product){
                array_push($all_array, $all_product->product_id);
                array_push($products_obj, $all_product->product_id);
            }
        }
        $all_products = Product::whereIn('id',$all_array)->orderBy('price','asc')->get();
        $count_all_products = $all_products->count();
        $i=0;
        foreach($all_products as $product){
            $i++;
            if($i==1){
                array_push($prices_obj,$product->price);
            }
            if($i==$count_all_products){
                array_push($prices_obj,$product->price);
            }
            if(!in_array($product->brand_id,$brands_obj)){
                array_push($brands_obj,$product->brand_id);
            }
            if(!in_array($product->manufacturer_id,$manufacturers_obj)){
                array_push($manufacturers_obj,$product->manufacturer_id);
            }
            // Attributes
            foreach( $product->attributes_without_pivot as $attr_query )
            if($attr_query){
                if(!in_array($attr_query->id,$attrs)){
                    array_push($attrs, $attr_query->id);
                }
                if($attr_query->group_id){
                    if(!in_array($attr_query->group_id,$attrs_groups)){
                        array_push($attrs_groups, $attr_query->group_id);
                    }
                }
            }
        }
        $brands = Brand::whereIn('id',$brands_obj)->get();
        $manufacturers = Manufacturer::whereIn('id',$manufacturers_obj)->get();
        $products = Product::whereIn('id',$all_array)->orderBy('id','desc')->paginate(15);
        $attrs_groups = Attribute::whereIn('id',$attrs_groups)->get();
        $attrs = Attribute::whereIn('id',$attrs)->get();
        return view('website.products.search-page')->with(compact('search','products','brands','manufacturers','prices_obj','attrs','attrs_groups'));
    }
    public function category($category,Request $request){
        $attrs_groups = [];
        $attrs = [];

        $products_obj = [];
        $brands_obj = [];
        $manufacturers_obj = [];
        $prices_obj = [];
        $sort = $request->input('sort') ? $request->input('sort') : 'desc';
        $cat = CategoryTranslation::where('slug','=',$category)->get()->first();
        $category = Category::find($cat->category_id);
        $productsc = ProductCategory::where('category_id','=',$category->id)->orderBy('id','desc')->get();
        foreach($productsc as $product){
            if(!in_array($product->product_id,$products_obj)){
                array_push($products_obj,$product->product_id);
            }
        }
        $all_products = Product::whereIn('id',$products_obj)->where('is_active','=',1)->orderBy('price',$sort)->get();
        $count_all_products = $all_products->count();
        $i=0;
        foreach($all_products as $product){
            $i++;
            if($i==1){
                array_push($prices_obj,$product->price);
            }
            if($i==$count_all_products){
                array_push($prices_obj,$product->price);
            }
            if(!in_array($product->brand_id,$brands_obj)){
                array_push($brands_obj,$product->brand_id);
            }
            if(!in_array($product->manufacturer_id,$manufacturers_obj)){
                array_push($manufacturers_obj,$product->manufacturer_id);
            }
            // Attributes
            foreach( $product->attributes_without_pivot as $attr_query )
            if($attr_query){
                if(!in_array($attr_query->id,$attrs)){
                    array_push($attrs, $attr_query->id);
                }
                if($attr_query->group_id){
                    if(!in_array($attr_query->group_id,$attrs_groups)){
                        array_push($attrs_groups, $attr_query->group_id);
                    }
                }
            }
        }
        $brands = Brand::whereIn('id',$brands_obj)->get();
        $manufacturers = Manufacturer::whereIn('id',$manufacturers_obj)->get();
        $products = Product::whereIn('id',$products_obj)->where('is_active','=',1)->orderBy('id',$sort)->paginate(15);
        $attrs_groups = $category->attributes()->pluck('attribute_id')->toArray();
        $attrs_groups = Attribute::whereIn('id',$attrs_groups)->where('group_id',null)->get();
        
        $attrs = Attribute::all();//whereIn('id',$attrs)->get();
        return view('website.products.search')->with(compact('category','products','brands','manufacturers','prices_obj','attrs','attrs_groups'));
                    
    }
    public function category_filter($category,Request $request){
        $prices = explode(",", $request->get('prices'));
        if($prices[0] < $prices[1]){
            $start = $prices[0];
            $end = $prices[1];
        }else{
            $start = $prices[1];
            $end = $prices[0];
        }
        $sort = $request->input('sort') ? $request->input('sort') : 'desc';
        $products_obj = [];
        $brands = $request->get('brands');
        $attrs = $request->get('attrs');
        $products_attrs_obj = [];
        $products_attrs_f_obj = [];
        if($brands != ""){
            if(strpos($brands, ",") !== false){
                $brands = explode(",", $request->get('brands'));
            }else{
                $brands = [$brands];
            }
        }
        $productsc = ProductCategory::where('category_id','=',$category)->orderBy('id','desc')->get();
        foreach($productsc as $product){
            if(!in_array($product->product_id,$products_obj)){
                array_push($products_obj,$product->product_id);
            }
        }
        $products = Product::whereIn('id',$products_obj)->where('price','>=',$start)->where('price','<=',$end);
        if($brands != ""){
            $products = $products->whereIn('brand_id',$brands);
        }
        $products = $products->orderBy('id',$sort)->paginate(15);
        if($attrs != ""){
            if(strpos($attrs, ",") !== false){
                $attrs = explode(",", $request->get('attrs'));
            }else{
                $attrs = [$attrs];
            }
            foreach($products as $product){
                if(!in_array($product->id, $products_attrs_obj)){
                    array_push($products_attrs_obj, $product->id);
                }
                $attrs_products = AttributeProduct::whereIn('product_id',$products_attrs_obj)->whereIn('attribute_id',$attrs)->get();
                foreach($attrs_products as $attr_product){
                    if(!in_array($product->id, $products_attrs_f_obj)){
                        array_push($products_attrs_f_obj, $attr_product->product_id);
                    }
                }
            }
            $products = Product::whereIn('id',$products_attrs_f_obj)->orderBy('id',$sort)->paginate(15);
        }
        return view('website.products.search_result')->with(compact('products'));
    }
    public function search_filter($category,Request $request){
        $specials = $request->get('specials');
        $prices = explode(",", $request->get('prices'));
        if($prices[0] < $prices[1]){
            $start = $prices[0];
            $end = $prices[1];
        }else{
            $start = $prices[1];
            $end = $prices[0];
        }
        $sort = $request->input('sort') ? $request->input('sort') : 'desc';
        $products_obj = [];
        $brands = $request->get('brands');
        $attrs = $request->get('attrs');
        $products_attrs_obj = [];
        $products_attrs_f_obj = [];
        $all_array = [];
        if($brands != ""){
            if(strpos($brands, ",") !== false){
                $brands = explode(",", $request->get('brands'));
            }else{
                $brands = [$brands];
            }
        }
        $all_array = [];
        if($specials){
            $all_products = Product::where('on_sale','=',1)->orWhere('is_hot','=',1)->orWhere('is_bundle','=',1)->orderBy('price','asc')->get();
            foreach($all_products as $all_product){
                array_push($all_array, $all_product->id);
                array_push($products_obj, $all_product->id);
            }
        }else{
            $all_products = ProductTranslation::where('name','LIKE','%'.$category.'%')->orderBy('id','desc')->get();
            foreach($all_products as $all_product){
                array_push($all_array, $all_product->product_id);
                array_push($products_obj, $all_product->product_id);
            }
        }
        foreach($all_products as $all_product){
            array_push($all_array, $all_product->product_id);
            array_push($products_obj, $all_product->product_id);
        }
        $products = Product::whereIn('id',$products_obj)->where('price','>=',$start)->where('price','<=',$end);
        if($brands != ""){
            $products = $products->whereIn('brand_id',$brands);
        }
        $products = $products->orderBy('id',$sort)->paginate(15);
        if($attrs != ""){
            if(strpos($attrs, ",") !== false){
                $attrs = explode(",", $request->get('attrs'));
            }else{
                $attrs = [$attrs];
            }
            foreach($products as $product){
                if(!in_array($product->id, $products_attrs_obj)){
                    array_push($products_attrs_obj, $product->id);
                }
                $attrs_products = AttributeProduct::whereIn('product_id',$products_attrs_obj)->whereIn('attribute_id',$attrs)->get();
                foreach($attrs_products as $attr_product){
                    if(!in_array($product->id, $products_attrs_f_obj)){
                        array_push($products_attrs_f_obj, $attr_product->product_id);
                    }
                }
            }
            $products = Product::whereIn('id',$products_attrs_f_obj)->orderBy('id',$sort)->paginate(15);
        }
        return view('website.products.search_result')->with(compact('products'));
    }

    
    public function dealsection($slug,Request $request){
        $dealsection = DealSectionTranslation::where('slug','=',$slug)->get()->first();
        $dsection = DealSection::find($dealsection->deal_section_id);
        $attrs_groups = [];
        $attrs = [];

        $products_obj = explode(',',$dealsection->product_ids()->product_ids);
        $brands_obj = [];
        $manufacturers_obj = [];
        $prices_obj = [];
        $sort = $request->input('sort') ? $request->input('sort') : 'desc';
        $category = $dealsection;
        $all_products = Product::whereIn('id',$products_obj)->orderBy('price',$sort)->get();
        $count_all_products = $all_products->count();
        $i=0;
        foreach($all_products as $product){
            $i++;
            if($i==1){
                array_push($prices_obj,$product->price);
            }
            if($i==$count_all_products){
                array_push($prices_obj,$product->price);
            }
            if(!in_array($product->brand_id,$brands_obj)){
                array_push($brands_obj,$product->brand_id);
            }
            if(!in_array($product->manufacturer_id,$manufacturers_obj)){
                array_push($manufacturers_obj,$product->manufacturer_id);
            }
            // Attributes
            foreach( $product->attributes_without_pivot as $attr_query )
            if($attr_query){
                if(!in_array($attr_query->id,$attrs)){
                    array_push($attrs, $attr_query->id);
                }
                if($attr_query->group_id){
                    if(!in_array($attr_query->group_id,$attrs_groups)){
                        array_push($attrs_groups, $attr_query->group_id);
                    }
                }
            }
        }
        $brands = Brand::whereIn('id',$brands_obj)->get();
        $manufacturers = Manufacturer::whereIn('id',$manufacturers_obj)->get();
        $products = Product::whereIn('id',$products_obj)->orderBy('id',$sort)->paginate(15);
        $attrs_groups = Attribute::whereIn('id',$attrs_groups)->get();
        $attrs = Attribute::whereIn('id',$attrs)->get();
        return view('website.products.search')->with(compact('category','products','brands','manufacturers','prices_obj','attrs','attrs_groups','dsection'));
                    
    }

    
}
