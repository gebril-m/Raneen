<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class Country extends Model
{
    use Translatable;
	public $translatedAttributes = ['name'];
    // protected $fillable = ['code'];
    public function cities (){
        return $this->hasMany(City::class);
    }
}
