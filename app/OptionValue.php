<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $table = 'options_values';
    protected $fillable = [
        'option_id',
        'value'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
