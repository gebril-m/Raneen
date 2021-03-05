<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Attribute;
use App\CategoryTranslation;
use App\Http\Controllers\Controller;
use DB;

class ProductsSearchApiController extends Controller
{

    public function MinMax()
    {
        $min = \DB::select('select MIN(price) as "minprice" from products')[0]->minprice;
        $max = \DB::select('select MAX(price) as "maxprice" from products')[0]->maxprice;
        return response()->json(['min'=>$min,'max'=>$max]);
    }

    public function search_minmax(Request $request, $min, $max){
        $products = Product::where('price','>=',$min)->where('price','<=',$max)->get();
        return $products;
    }
    public function search(Request $request){

        $specialsCols = ['on_sale', 'up_selling', 'is_hot', 'is_bundle'];
        $sortBy = 'id';
        $orderBy = 'asc';
        $perPage = 20;
        $price = null;
        $brand = null;
        $cat = null;
        $catInp = null;
        $name = null;
        $attributes = null;
        $specials = null;

        if ($request->has('orderBy')) $orderBy = $request->input('orderBy');
        if ($request->has('sortBy')) $sortBy = $request->input('sortBy');
        if ($request->has('perPage')) $perPage = $request->input('perPage');
        if ($request->has('price')) $price = $request->input('price');
        if ($request->has('brand')) $brand = $request->input('brand');
        if ($request->has('cat')) $catInp = $request->input('cat');
        if ($request->has('name')) $name = $request->input('name');
        if ($request->has('attributes')) $attributes = $request->input('attributes');
        if ($request->has('specials')) $specials = $request->input('specials');


        // in case if user asked for all we need to treat the cat as empty
        if ($catInp == 'all'){
            $catInp = null;
        }

        $dynamicFilters = Attribute::parents()
                        ->with('translations:attribute_id,name,locale')
                        ->get()
                        ->pluck('name:en');

        $productsQuery = Product::query();
        $productsQuery->where('is_active','1');
        # if name provided
        if(!empty($name)){
            $productsQuery->whereHas('translations', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%'.$name.'%');
            });
        }


        # if category provided
        if(!empty($catInp)){

            $cat = CategoryTranslation::where('slug', $catInp)->first();
            $catId = (!empty($cat)) ?  $cat->category_id :  0 ;
            $ids =  rtrim($catId . ',' . $this->getCatChildrens($catId), ',');

            $productsQuery->whereHas('categories', function ($query) use ($ids) {
                $query->whereIn('categories.id', explode(',', $ids));
            });

        }

        # brands
        if(!empty($brand)){
            $productsQuery->whereHas('brand.translations', function ($query) use ($brand) {
                $query->Where(function ($query) use($brand) {
                    foreach ($brand as $b){
                        $query->orwhere('name', 'like',  '%' . $b .'%');
                    }
                });
            });
        }

        # handle dynamic attributes
        $dynamicFiltersArr = [];

        foreach($dynamicFilters as $df){
            if ($request->has($df)){
                if(!empty($request->input($df))){
                    $dynamicFiltersArr[] = $request->input($df);
                }
            }
        }

        if(!empty($dynamicFiltersArr)){

            $attributes = array_merge(...$dynamicFiltersArr);
            $productsQuery->whereHas('attributes.translations', function ($query) use ($attributes) {
                $query->Where(function ($query) use($attributes) {
                    foreach ($attributes as $a){
                        $query->orwhere('name', 'like',  '%' . $a .'%');
                    }
                });
            });

        }


        if(!empty($price)){


            $productsQuery->Where(function($query) use ($price){


                $query->where('price','<=',$price)->orWhere('before_price','<=',$price);


            });

        }

        # special
        if(!empty($specials)){
            $specials = explode(',', $specials);
            foreach($specials as $special){
                if( in_array($special, $specialsCols) ){
                    $productsQuery->Where($special, '=', 1);
                }
            }
        }

        # execute query
        $catProducts = $productsQuery->productsApi()
                                     ->with('categories')
                                     ->orderBy($sortBy, $orderBy)
                                     ->paginate($perPage);


        $initialSearchCount = $catProducts->count();

        if($catProducts->count() == 0){
            $catProducts = Product::productsApi()
                                         ->with('categories')
                                         ->orderBy($sortBy, $orderBy)
                                         ->paginate($perPage);
        }


        if($catProducts)
        foreach ($catProducts as $product) {
            $product->before_price         = $product->product_before_price;
            $product->price         = $product->product_price;
            $product->url           = $product->url;
            $product->thumbnail     = $product->thumbnail_url;
        }

        $filters = $this->getFilters($catInp);

        return [
            'filters' => $filters,
            'category' => $cat,
            'products' => $catProducts,
            'initialSearchCount' => $initialSearchCount
        ];

    }

    public function getDynamicFilters($attributes, &$filters){

        foreach($attributes as $a) {
            foreach($a as $attr){
                if(isset($attr->parentRow)) {
                    $filters['list'][$attr->parentRow->translate('en')->name][$attr->id] = $attr->translate('en')->name;
                }
            }
        }

        return $filters;

    }

    public function getFilters($cat){

        $productsQuery = Product::query();
        $filters = [];
        // does user asked for specific category
        if(!empty($cat)){
            $catRow = CategoryTranslation::where('slug', $cat)->first();
            $catId = (!empty($catRow)) ?  $catRow->category_id :  0 ;
            $productsQuery->whereHas('categories', function ($query) use ($catId) {
                $query->where('categories.id', $catId);
            });
        }

        $catProducts = $productsQuery->get();

        if($catProducts->count() != 0){

            $filters['list'] = [];
            $filters['list']['brand']  = $catProducts->pluck('brand.name', 'brand.id')->filter()->unique();

            $p = [];
            $pricesArr = $catProducts->pluck('product_price')->filter()->toArray();
            sort($pricesArr);
            $pricesChunks = [];
            // (int)floor(count($pricesArr) / 2)
            $pricesChunks = array_chunk( $pricesArr , 5 ) ;

            foreach($pricesChunks as $k => $chunk){
                if(count($chunk) != 1){
                    $p[] = min($chunk) . "-" . max($chunk);
                    if( $k != (count($pricesChunks) - 1 ) ){
                        $p[] = max($chunk) . "-" . $pricesChunks[$k+1][0];
                    }
                }
            }

            if($catProducts->pluck('attributes')->count())
                $this->getDynamicFilters( $catProducts->pluck('attributes')->unique(), $filters );

            $filters['list']['price']  = $p;
        }

        return $filters;
    }

    public function getCatChildrens($catId){

        $sql = "SELECT GROUP_CONCAT(lv SEPARATOR ',') as childrens FROM ( SELECT @pv:=(SELECT GROUP_CONCAT(id SEPARATOR ',') FROM categories WHERE parent_id IN (@pv)) AS lv FROM categories JOIN (SELECT @pv:=$catId)tmp WHERE parent_id IN (@pv)) a";
        $data = DB::select(DB::raw( $sql ));
        return $data[0]->childrens;
        // $string = trim(preg_replace('/\s\s+/', ' ', $string));

    }

}
