<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\MainSetting;
class Point extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function convert_money($points){
        $points_value = MainSetting::where('key','=','point_value')->get()->first();
        $money = $points*$points_value->value;
        return $money;
    }
}
