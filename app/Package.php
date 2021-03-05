<?php

namespace App;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use Translatable ;
    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['is_active'];

    
}
