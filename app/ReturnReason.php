<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;

class ReturnReason extends Model
{
    //
    use Translatable;
	public $translatedAttributes = ['name'];
    // protected $fillable = ['code'];
    public function reasons (){
        return $this->hasMany(ReturnReasonTranslation::class);
    }
}
