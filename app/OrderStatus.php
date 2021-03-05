<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    protected $table = 'order_status';

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
