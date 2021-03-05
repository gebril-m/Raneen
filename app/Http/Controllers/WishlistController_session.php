<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class WishlistController extends Controller
{

    function show(){
        return view('checkout.wishlist');
    }

    function store(Request $request) {

        $id = ($request->input('id')) ? $request->input('id') : '' ;

        $wishlistSession = (session()->has('products.wishlist')) ? session()->get('products.wishlist') : [] ;

        if(!array_key_exists($id, $wishlistSession)){
            session()->push('products.wishlist.'.$id, $id);
        }

        return [
            'status'=>'success'
        ];

    }

    function getWishlist(){

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
            $outPut['price'] = $item['product_price'];
            $outPut['thumbnail'] = $item['thumbnail'];
            $outPut['description'] = $item['description'];
            $counter += $item['product_price'];
            return $outPut;
        })->all();

        $nproducts['wishlistProducts'] = $products;
        $nproducts['totalPrice'] = $counter;

        return $nproducts;

    }

    function delete(Request $request){

        $id = ($request->input('id')) ? $request->input('id') : '' ;
        $wishlistSession = (session()->has('products.wishlist')) ? session()->get('products.wishlist') : [] ;

        if(array_key_exists($id, $wishlistSession)){
            session()->forget('products.wishlist.'.$id );
        }

        return [
            'status'=>'success'
        ];


    }

}
