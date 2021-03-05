<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function product (){
		return $this->belongsTo(Product::class);
	}

}
