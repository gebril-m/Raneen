<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\CategoryTranslation;
use App\Review;
use Auth;

class ProductsController extends Controller
{
    public function write_review(Request $request, $id){

        $rating = (int)$request->input('rating');


        $product = Product::whereHas('translations', function ($query) use ($id){
            $query->where('product_id', $id);
        })->with('images', 'reviews')->whereIsActive(true)->first();


        $new = new Review;
        $new->item_id = $request->input('p_r_id');
        $new->user_id = Auth::user()->id;
        $new->review_title = $request->input('title');
        $new->review = $request->input('body');

        if($rating && $rating != 0){
            $new->rate = $request->input('rating');
        }else{
            $new->rate = 1;
        }
        $new->save();
        return back()->with('message', 'Your Review Has Been Submitted');
    }
    # single product by slug
    public function show($slug)
    {
        $product = Product::whereHas('translations', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('images', 'reviews')->whereIsActive(true)->firstOrFail();
        $p_r_id = $product->id;
        $product_reviews = $product->get_reviews();
        if($product->is_combo == 1){
            $combo = $product->id;
            $product_reviews = $product->get_reviews();
            $p_r_id = $product->id;
            $p_id = $product->get_bundle_products($product->id)[0]->slug;
            $product = Product::whereHas('translations', function ($query) use ($p_id) {
                $query->where('slug', $p_id);
            })->with('images', 'reviews')->whereIsActive(true)->firstOrFail();
        }else{
            $combo = 0;
        }
        if($product->is_bundle == 1){
            $bundle = $product->id;
            $product_reviews = $product->get_reviews();
            $p_r_id = $product->id;
            $p_id = $product->get_bundle_products($product->id)[0]->slug;
            $product = Product::whereHas('translations', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })->with('images', 'reviews')->whereIsActive(true)->firstOrFail();
        }else{
            $bundle = 0;
        }
        // return($product->images);
        $attrs = [];
        foreach($product->attributes as $attr){
            if(isset($attr->parentRow->name)){
                $attrs[$attr->parentRow->translate('en')->name][$attr->translate('en')->name]['quantity'][] =  $attr->pivot->quantity;
            }
        }

        if(auth()->check()){
            $review = $this->isUserAlreadyReviewed($product, auth()->user()->id, $product->id);
            $product->userAlreadyReviewed = $review;
        }

        $related_products = $product->related_products;
        # avg rate for this attribute

        $visited_ids = session('visited_products', []);
        unset($visited_ids[ array_search($product->id, $visited_ids) ]);

        $visited_ids[] = $product->id;

        session([
            'visited_products' => $visited_ids
        ]);

        return view('website.products.details')->with(compact('product_reviews','product', 'attrs', 'related_products','combo','bundle','p_r_id'));

    }

    public function isUserAlreadyReviewed($product, $uid, $pid){
        $review = $product->reviews->where('user_id', $uid)->where('item_id', $pid)->first();
        return !empty($review);
    }

}
