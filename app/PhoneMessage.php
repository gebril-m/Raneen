<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneMessage extends Model
{
    protected $table = 'phone_messages';
    protected $fillable = [
        'text',
        'lang',
        'receiver',
        'status',
        'user_id'
    ];
}
