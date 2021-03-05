<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuponLog extends Model
{
    protected $table = 'cupons_logs';
    protected $fillable = [
        'cupon_id',
        'user_id',
        'order_id',
        'amount_before',
        'amount_after',
        'cupon'
    ];
}
