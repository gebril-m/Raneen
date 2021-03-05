<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use Translatable ;
    public $translatedAttributes = ['name'];

    public function products() {
        return $this->belongsToMany(Product::class, 'inventory_products')->withPivot('id', 'quantity');
    }
    public function get_state($id){
        return State::find($id);
    }

}
