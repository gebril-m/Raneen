<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComboValue extends Model
{
    protected $fillable=['num','percentage','combo_id'];

    public function combo()
    {
    	return $this->belongsTo(Combo::class);
    }

}
