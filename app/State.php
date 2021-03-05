<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class State extends Model
{

    use Translatable ;
    use \Dimsav\Translatable\Translatable;

	public $translatedAttributes = ['name'];
    // protected $fillable = ['code'];
    public function city (){
        return $this->belongsTo(City::class);
     }

    public function country (){
        return $this->belongsTo(Country::class);
     }
}
