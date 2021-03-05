<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
class ComboController extends Controller
{
    //
    public function check_combo_price($ids,$combo_id){
    	$before_price = 0;
    	$after_price = 0;
    	$product_ids = explode(',', $ids);
    	$combo = Product::find($combo_id);
        $all_combos = Product::whereIn('id',$product_ids)->get();
        $combo_count = $all_combos->count();
        $product_free_id = 0;

        if($combo_count >= 1){
            $combo_count_str = "combo_".$combo_count;
            $combo_discount = $combo->$combo_count_str;
            if($combo_count == 5){
                $combo_5_free = $combo->combo_5_free;
                $product_free = 0;
                if($combo_5_free == 1){
                    foreach($all_combos as $product){
                        if($product_free == 0){
                            $product_free = $product->price;
                            $product_free_id = $product->id;
                        }else{
                            if($product->price < $product_free){
                                $product_free = $product->price;
                                $product_free_id = $product->id;
                            }
                        }
                    }
                }
            }
        }else{
            $combo_discount = 0;
        }
        foreach($all_combos as $product){
        	if($product->before_price == 0){
        		$before_price_p = $product->price;
        	}else{
        		$before_price_p = $product->before_price;
        	}
        	if($product_free_id == $product->id){
        		$after_price_p = 0;
        	}else{
        		$after_price_p = $before_price_p-($before_price_p*$combo_discount/100);
        	}
        	$after_price += $after_price_p;
        	$before_price += $before_price_p;
        }
    	return [$before_price,$after_price];
    }
}
