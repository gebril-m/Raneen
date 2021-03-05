<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\DealSectionTranslation;
class DealSection extends Model
{
    //
    use Translatable ;
    public $translatedAttributes = ['name','slug'];
    protected $hidden = ['created_at','updated_at'];
}
