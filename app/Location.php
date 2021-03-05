<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Location extends Model
{
    use Translatable ;

	public $translatedAttributes = ['location'];
    // protected $fillable = ['code'];

    public function city (){
        return $this->belongsTo(City::class);
     }
}
