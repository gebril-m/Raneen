<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
