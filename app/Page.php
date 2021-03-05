<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Translatable ;
    public $translatedAttributes = ['name', 'body','slug'];
    protected $fillable = ['is_active','show_footer','show_header'];

}
