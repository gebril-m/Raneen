<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ShippingCompany;
class ShippingZone extends Model
{
    //
    public function get_areas(){
    	return $areas = explode(',',$this->areas);
    	$areas = ShippingCompany::whereIn('id',$areas)->get();
    	$areas_text = '';
    	foreach ($areas as $area) {
    		$areas_text .= $area->name.",";
    	}
    	return $areas_text;
    }
    public function company(){
    	return $this->belongsTo(ShippingCompany::class);
    }
}
