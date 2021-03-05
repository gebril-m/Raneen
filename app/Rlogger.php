<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rlogger extends Model
{
    protected $fillable = ['msg', 'model_id', 'user_id'];
    protected $table = 'logs';
    protected $hidden = ['created_at', 'updated_at'];
}
