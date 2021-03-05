<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderProduct;
class Withdraw extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function order_product($id){
        return OrderProduct::find($id);
    }
}
