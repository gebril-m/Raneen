<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\BrandTranslation;

class Brand extends Model
{
    use Translatable ;
    public $translatedAttributes = ['name'];

    public function products() {
        return $this->hasMany(Product::class);
        
    }


    public function get_seo($lang,$column,$id){
        $product = BrandTranslation::where('locale','=',$lang)->where('brand_id','=',$id)->get()->first();
        if(!$product){
            return '';
        }else{
            return $product->$column;
        }
    }
    public function get_translate($lang,$column,$id){
        $product = BrandTranslation::where('locale','=',$lang)->where('brand_id','=',$id)->get()->first();
        if(!$product){
            return '';
        }else{
            return $product->$column;
        }
    }
    public function getLogoThumbAttribute() {
        if (substr($this->logo, 0, 4) == 'http') return $this->logo;
        return route('thumb', [
            'brand',
            64, 64,
            $this->logo
        ]);
    }

}
