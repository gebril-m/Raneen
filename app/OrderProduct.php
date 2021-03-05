<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    protected $table = "order_product";
    public function order(){
    	return $this->belongsTo(Order::class);
    }
    public function product(){
    	return $this->belongsTo(Product::class);
    }
    public function return_reason(){
    	return $this->belongsTo(ReturnReason::class);
    }
}
