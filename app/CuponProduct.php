<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuponProduct extends Model
{
    public $table='cupon_product';

    protected $fillable = ['product_id','cupon_id'];
}
