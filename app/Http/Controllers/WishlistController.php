<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function __construct(){
//        $this->middleware('auth');
    }

    function show(){
        $cart = $this->getWishlist();
        $cart = $cart['wishlistProducts'];
        // dd($cart);
        return view('website.users.wishlist')->with(compact('cart'));
    }

    function store(Request $request) {
        $status = false;

        if(!Auth::check()){

            $id = ($request->input('id')) ? $request->input('id') : '' ;

            $wishlistSession = (session()->has('products.wishlist')) ? session()->get('products.wishlist') : [] ;

            if(!array_key_exists($id, $wishlistSession)){
                session()->push('products.wishlist.'.$id, $id);
            }

            $status = true;

        }else{

            $uid = auth()->user()->id;
            $pid = ($request->input('id')) ? $request->input('id') : '' ;
            $wishlistCheck = Wishlist::where('product_id', $pid)->first();

            if( empty($wishlistCheck) ){
                Wishlist::create([
                    'user_id' => $uid,
                    'product_id' => $pid
                ]);
                $status = true;
            }

        }

        return [
            'status' => $status
        ];


    }

    function getWishlist(){

        if(!Auth::check()) {

            $wishlist = (session()->has('products.wishlist'))
                ? session()->get('products.wishlist'):
                [];

            $products = Product::with('translations:id,product_id,name,locale,slug')
                ->whereIn( 'id', array_keys($wishlist) )
                ->select ( 'id', 'thumbnail', 'price', 'before_price','stock' )
                ->get();

        } else {

            $uid = auth()->user()->id;
            # if user logged in we need to grab the wishlist session and add it to database
            $wishlist = (session()->has('products.wishlist')) ? session()->get('products.wishlist'): [];
            if(!empty($wishlist)){
                $wishlistproductsIds = [];
                foreach ($wishlist as $k => $w){
                    $wishlistproductsIds[] = [
                        'user_id' => $uid,
                        'product_id' => $k
                    ];
                }
                Wishlist::insert($wishlistproductsIds);
                # forget wishlist session
                session()->forget('products.wishlist');
            }


            $wishlistItems = Wishlist::where('user_id', $uid)->pluck('product_id');

            $products = Product::with('translations:id,product_id,name,locale,slug')
                ->whereIn( 'id', $wishlistItems )
                ->select ( 'id', 'thumbnail', 'price', 'before_price','stock' )
                ->get();
        }

        $counter = 0;
        $products = $products->map(function($item) use (&$counter){
            $getimages = $item->get_images($item['id']);
            $outPut = [];
            $outPut['id'] = $item['id'];
            $outPut['url'] = $item['url'];
            $outPut['name'] = $item['name'];
            $outPut['slug'] = $item['slug'];
            $outPut['price'] = $item['product_price'];
            $outPut['before_price'] = $item['before_price'];
            $outPut['is_bundle'] = $item['is_bundle'];
            $outPut['is_combo'] = $item['is_combo'];
            $outPut['stock'] = $item['stock'];
            $outPut['minimum_stock'] = $item['minimum_stock'];
            
            // $outPut['thumbnail'] = image('product', $item['thumbnail']);
            if(count($getimages) > 0){
                $outPut['thumbnail'] = image('product', $getimages[0]);
            }else{
                $outPut['thumbnail'] = image('product', $item['thumbnail']);
            }
            $outPut['description'] = $item['description'];
            $counter += $item['product_price'];
            return $outPut;
        })->all();

        $nproducts['wishlistProducts'] = $products;
        $nproducts['totalPrice'] = $counter;

        return $nproducts;

    }

    function delete(Request $request){

        if(!Auth::check()) {
            $id = ($request->input('id')) ? $request->input('id') : '' ;
            $wishlistSession = (session()->has('products.wishlist')) ? session()->get('products.wishlist') : [] ;

            if(array_key_exists($id, $wishlistSession)){
                session()->forget('products.wishlist.'.$id );
            }
        } else {
            $uid = auth()->user()->id;
            $pid = ($request->input('id')) ? $request->input('id') : '' ;
            $delete = Wishlist::where([
                ['user_id', $uid],
                ['product_id', $pid]
            ])->delete();
        }

        return [
            'status'=>'success'
        ];


    }

}
