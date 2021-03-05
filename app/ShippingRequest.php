<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingRequest extends Model
{
    //
    public function company(){
        return $this->belongsTo(ShippingCompany::class);
    }
}
