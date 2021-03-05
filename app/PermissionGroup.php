<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $table = 'permissions_groups';
    protected $fillable = ['name'];
}
