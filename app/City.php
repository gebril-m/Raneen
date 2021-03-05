<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class City extends Model
{
    use Translatable;

	public $translatedAttributes = ['name'];
    // protected $fillable = ['code'];

    public function country (){
        return $this->belongsTo(Country::class);
    }
}
