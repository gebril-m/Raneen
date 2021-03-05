<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPromotion extends Model
{
    public $table='promotion_product';
    protected $fillable=['product_id','promotion_id'];
}
