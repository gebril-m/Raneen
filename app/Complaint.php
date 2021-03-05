<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Complaint extends Model
{
    //
    public function get_user($id){
        return User::find($id);
    }
}
