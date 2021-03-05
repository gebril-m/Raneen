<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComboCategory extends Model
{
    public $table='category_combo';
    protected $fillable=['combo_id','category_id'];
}
