<?php

namespace App\Http\Controllers\Website;

use App\Page;
use App\Http\Controllers\Api\V1\ProductsSearchApiController as psc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
Use View;
use App\ProductCategory;
use App\CategoryTranslation;
use App\ProductTranslation;
use App\BrandTranslation;
use App\ManufacturerTranslation;
use App\Product;
class SearchController extends Controller
{
    public function __construct()
    {
        $locale = App::getLocale();
        View::share('key', 'value');
        View::share('locale',$locale);
        $this->middleware('verified');
    }
    public function index($category,Request $request){
        $locale = App::getLocale();
        $brands_obj = [];
        $manufacturers_obj = [];
        $products_obj = [];
        $category = CategoryTranslation::where('locale','=',$locale)->where('slug','=',$category)->get()->first();
        $product_category = ProductCategory::where('category_id','=',$category->category_id)->get();
        foreach ($product_category as $product) {
            array_push($products_obj, $product->product_id);
        }
        $products_arr = Product::whereIn('id',$products_obj)->get();
        foreach ($products_arr as $product) {
            $brand_id = $product->brand_id;
            $manufacturer_id = $product->manufacturer_id;
            if(!in_array($brand_id, $brands_obj)){
                array_push($brands_obj, $brand_id);
                array_push($manufacturers_obj, $manufacturer_id);
            }
        }
        $brands = BrandTranslation::whereIn('brand_id',$brands_obj)->where('locale','=',$locale)->get();
        $manufacturers = ManufacturerTranslation::whereIn('manufacturer_id',$manufacturers_obj)->where('locale','=',$locale)->get();
        $products = ProductTranslation::whereIn('product_id',$products_obj)->where('locale','=',$locale)->get();
        return view('website.products.search')->with(compact('brands','manufacturers','products','category'));
    }
}
