<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class UserDetail extends Model
{
    protected $table = 'user_details';
    protected $fillable = [
        'first_name', 
        'last_name', 
        'phone',
        'country_id', 
        'address', 
        'city_id', 
        'state', 
        'postal_code', 
        'user_id',
        'email'
    ];
}
