<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $table = 'attributes_groups';
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
