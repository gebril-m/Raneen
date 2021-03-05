<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\ManufacturerTranslation;

class Manufacturer extends Model
{
    
    use Translatable ;
    public $translatedAttributes = ['name'];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function get_seo($lang,$column,$id){
        $product = ManufacturerTranslation::where('locale','=',$lang)->where('manufacturer_id','=',$id)->get()->first();
        if(!$product){
            return '';
        }else{
            return $product->$column;
        }
    }
    public function getLogoThumbAttribute() {
        if (substr($this->logo, 0, 4) == 'http') return $this->logo;
        return route('thumb', [
            'manufacturer',
            64, 64,
            $this->logo
        ]);
    }

}
