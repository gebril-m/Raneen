<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    protected $fillable = ['locale','attribute_id', 'name'];
}
