<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'field_id',
        'name'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function values(){
        return $this->hasMany(OptionValue::class);
    }
}
