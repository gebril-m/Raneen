<?php

namespace App;

use Dimsav\Translatable\Translatable;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class BundleProduct extends Model
{
    public function products() {
        return $this->hasMany(Product::class,'id','product_id');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function getTotalOldPrice($id){
        $bundles = BundleProduct::where('bundle_id', $id)->get();

        $bundles->map(function ($bundle) use (&$discount, &$old_price) {

            $old_price += $bundle->product->before_price > 0? $bundle->product->before_price * $bundle->quantity: $bundle->product->price * $bundle->quantity ;

        });


        return $old_price;
    }
    public function getPrice($id){
        $bundles = BundleProduct::where('bundle_id', $id)->get();

        return $this->getTotalOldPrice($id) - $bundles->sum('discount');
    }

    public static function checkQuantity(\Illuminate\Http\Request $request){

        $items = Product::whereIn('id',$request->products)->get();

        $productsRuinedQuantity = [];
        foreach ($items as $id =>$item){

            if ($item->stock < $request->quantity[$id])
                array_push($productsRuinedQuantity, $id+1);

        }
        if(!empty($productsRuinedQuantity)){
           return $productsRuinedQuantity;

        }
    }
}
