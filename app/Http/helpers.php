<?php

use App\Category;
use App\Product;
use App\Wishlist;
use App\ProductPromotion;
use App\Notifications\Phone\PhoneMessageService;
use Illuminate\Support\Facades\Log;
function module($place) {
    $module = \App\Module::wherePlace($place)->whereIsActive(1)->first();
    if (!$module) return '';
    $content = json_decode($module->content);
    $locale = app()->getLocale();

    $view = view('modules.' . $place, compact('content', 'locale'));
    return $view;
}

function modules() {
    $modules = \App\Module::whereIsActive(1)->orderBy('order_id', 'ASC')->get();

    $html = '';
    foreach ($modules as $module) {
        $content = json_decode($module->content);
        $locale = app()->getLocale();

        $view = view('modules.' . $module->place, compact('content', 'locale'));
        $html .= $view;
    }

    return $html;
}

function categories() {
    $dbCat = Category::get();
    $categories = [];
    getCategories($dbCat, $categories);

    return $categories;
}

function words_limit($str, $maxlen): string
{
    if (strlen($str) <= $maxlen) return $str;

    $newstr = substr($str, 0, $maxlen);
    if (substr($newstr, -1, 1) != ' ') $newstr = substr($newstr, 0, strrpos($newstr, " ")) . '...';

    return $newstr;
}

function upload_file( $file, $folder ) {
    if ($file && $file->isValid()) {
        $image_extension = $file->getClientOriginalExtension();
        $img_new_name = str_slug(str_random()) . "." . $image_extension;

        $path = strtolower("images/" . $folder . "/" . $img_new_name);
        $image = file_get_contents($file);
        \Storage::put($path, $image);

        return strtolower($img_new_name);
    }
    return null;
}
function upload_file_original( $file, $folder ) {
    if ($file && $file->isValid()) {
        $image_extension = $file->getClientOriginalExtension();
        $img_new_name = $file->getClientOriginalName();

        $path = strtolower("images/" . $folder . "/" . $img_new_name);
        $image = file_get_contents($file);
        \Storage::put($path, $image);

        return strtolower($img_new_name);
    }
    return null;
}

function image($type, $image) {
    if (substr($image, 0, 7) == 'http://') return $image;
    else if (substr($image, 0, 8) == 'https://') return $image;

    return route('image', [ $type, $image ]);
}
function images($type, $image) {
    if (substr($image, 0, 7) == 'http://') return $image;
    else if (substr($image, 0, 8) == 'https://') return $image;

    return route('images', [ $type, $image ]);
}

function thumb($type, $x, $y, $image) {
    if (substr($image, 0, 7) == 'http://') return $image;
    else if (substr($image, 0, 8) == 'https://') return $image;

    return route('thumb', [ $type, $x, $y, $image ]);
}

function lang_url($url) {
    return \LaravelLocalization::localizeUrl($url);
}

function url_lang($url, $locale) {
    return \LaravelLocalization::localizeUrl($url, $locale);
}

function route_lang($route, $params = []) {
    return \LaravelLocalization::localizeURL(route($route, $params, false), app()->getLocale());
}

function getCategories($categories = null, &$result = [], $parent_id = 0, $depth = 0)
{

    if (!$categories) $categories = \App\Category::all();

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
        getCategories($categories, $result, $cat->id, $depth + 1);
    }
}
function replaceLang($local){
    $segments = request()->segments();
    if(isset($segments[0])){
        if(strlen($segments[0]) > 2){
            if($local == 'en'){
                return url('/en/'.implode('/', $segments));
            }else{
                return url(implode('/', $segments));
            }
        }
    }
        $segments[0] = $local;
        return url(implode('/', $segments));

}
function getWishlistUser(){

    $uid = auth()->user()->id;
    $wishlistItems = Wishlist::where('user_id', $uid)->pluck('product_id');

    $products = Product::with('translations:id,product_id,name,locale,slug')
        ->whereIn( 'id', $wishlistItems )
        ->select ( 'id', 'thumbnail', 'price' )
        ->get();

    $counter = 0;
    $products = $products->map(function($item) use (&$counter){
        $outPut = [];
        $outPut['id'] = $item['id'];
        $outPut['url'] = $item['url'];
        $outPut['name'] = $item['name'];
        $outPut['slug'] = $item['slug'];
        $outPut['price'] = $item['price'];
        $outPut['thumbnail'] = $item['thumbnail'];
        $outPut['description'] = $item['description'];
        $counter += $item['price'];
        return $outPut;
    })->all();
    return $products;

}

function getWishSession(){

    $wishlist = (session()->has('products.wishlist'))
        ? session()->get('products.wishlist'):
        [];

    $products = Product::with('translations:id,product_id,name,locale,slug')
        ->whereIn( 'id', array_keys($wishlist) )
        ->select ( 'id', 'thumbnail', 'price' )
        ->get();

    $counter = 0;
    $products = $products->map(function($item) use (&$counter){
        $outPut = [];
        $outPut['id'] = $item['id'];
        $outPut['url'] = $item['url'];
        $outPut['name'] = $item['name'];
        $outPut['slug'] = $item['slug'];
        $outPut['price'] = $item['price'];
        $outPut['thumbnail'] = $item['thumbnail'];
        $outPut['description'] = $item['description'];
        $counter += $item['price'];
        return $outPut;
    })->all();
    return $products;

}

function getWishListsProductsId()
{
    $ids = [];
    $wishlist = (session()->has('products.wishlist'))
        ? session()->get('products.wishlist'):
        [];

    $products = Product::with('translations:id,product_id,name,locale,slug')
        ->whereIn( 'id', array_keys($wishlist) )
        ->select ( 'id', 'thumbnail', 'price' )
        ->get();

    

    $counter = 0;
    $products = $products->map(function($item) use (&$counter){
        $outPut = [];
        $outPut['id'] = $item['id'];
        return $outPut;
    })->all();

    foreach ($products as $product) {
        array_push($ids,$product['id']);
    }

    return $ids;
}
function getCompareSession(){

    $compare = (session()->has('compare'))
        ? session()->get('compare'):
        [];
    return count($compare);

}
function getCompareProductsId()
{
    $ids = [];
    $wishlist = (session()->has('products.wishlist'))
        ? session()->get('products.wishlist'):
        [];

    $products = Product::with('translations:id,product_id,name,locale,slug')
        ->whereIn( 'id', array_keys($wishlist) )
        ->select ( 'id', 'thumbnail', 'price' )
        ->get();

    

    $counter = 0;
    $products = $products->map(function($item) use (&$counter){
        $outPut = [];
        $outPut['id'] = $item['id'];
        return $outPut;
    })->all();

    foreach ($products as $product) {
        array_push($ids,$product['id']);
    }

    return $ids;
}

function sendPhoneMessageNotification($text, $receiver){
    $phoneMessage = new PhoneMessageService;
    $phoneMessage->messageText = $text;
    $phoneMessage->messageReceiver = ($receiver) ? $receiver: '';
    return $phoneMessage->sendMessage();
}

function genRandomCode($n = 7) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

function logToDatabase($payload){
    return Log::channel('db')->info('m', $payload);
}

function priorties(){
    return \App\Periorty::all();
}
function priorty($order_id,$id){
    $product=\App\Product::find($id);
    $priorties=\App\Periorty::all();
    
    $orders=[];
    if (count($product->get_bundle_products($id)) > 0) {
        array_push($orders, \App\Periorty::where('name','bundle')->first()->order_id);
    }
    if (count($product->combos) > 0) {
        array_push($orders, \App\Periorty::where('name','combo')->first()->order_id);
    }
    if ($product->is_hot) {
        array_push($orders, \App\Periorty::where('name','hot')->first()->order_id);
    }
    if ($product->on_sale) {
        array_push($orders, \App\Periorty::where('name','on_sale')->first()->order_id);
    }

    foreach ($orders as $key => $order) {
        if($order<$order_id){
            return false;
        }
    }
    return true;
}

function get_priroty_array()
{
    return [
            'combo_order_id'=>\App\Periorty::where('name','combo')->first()->order_id,
            'on_sale_order_id'=>\App\Periorty::where('name','on_sale')->first()->order_id,
            'hot_order_id'=>\App\Periorty::where('name','hot')->first()->order_id,
            'promotion_order_id'=>\App\Periorty::where('name','promotion')->first()->order_id,
            'bundle_order_id'=>\App\Periorty::where('name','bundle')->first()->order_id,
            'coupon_order_id'=>\App\Periorty::where('name','coupon')->first()->order_id
        ];
}
function get_product_priroty_array($id)
{
        $priroty = get_priroty_array();
        $product=\App\Product::find($id);
        $offer=[];
        if ($product->is_bundle) {
            $offer['bundle_order_id']=$priroty['bundle_order_id'];
        }
        if (count($product->promotions()->get()) > 0) {
            $offer['promotion_order_id']=$priroty['promotion_order_id'];
        }
        if ($product->on_sale) {
            $offer['on_sale_order_id']=$priroty['on_sale_order_id'];
        }
        if ($product->is_hot) {
            $offer['hot_order_id']=$priroty['hot_order_id'];
        }
        if (count($product->cupons()->get()) > 0) {
            $offer['coupon_order_id']=$priroty['coupon_order_id'];
        }
        return $offer;
}

function has_cupon($id)
{
    $product=\App\Product::find($id);
    $offer=get_product_priroty_array($id);
    if (count($product->cupons()->get()) == 0 ) {
        return false;
    }elseif($offer['coupon_order_id']==min($offer)){
        return true;
    }else{
        return false;
    }

}

function has_this_cupon($cupon_id,$product_id)
{
    if ($cupon_product=\App\CuponProduct::where('cupon_id',$cupon_id)->where('product_id',$product_id)->first() ) {
            return true;
        }
        return false;
}

function cupon_has_priroty($product_id){
    $offer=get_product_priroty_array($product_id);
    if (isset($offer['coupon_order_id']) && $offer['coupon_order_id']==min($offer)) {
        return true;
    }
    return false;
}

function has_any_discount($id)
{
    $product=\App\Product::find($id);
    if ($product->on_sale || $product->is_hot || $promotion=\App\ProductPromotion::where('product_id',$id)->first()|| $bundle=\App\BundleProduct::where('product_id',$id)->first() || $bundle=\App\BundleProduct::where('product_id',$id)->first()) {
       return true;
    }else{
        return false;
    }
}

