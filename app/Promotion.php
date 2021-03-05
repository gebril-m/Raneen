<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{

    protected $fillable = [
	    'name',
	    'type', 
	    'amount', 
	    'start', 
	    'end', 
	    'is_active'
	];

	protected $hidden = [
	    'created_at', 
	    'updated_at'
    ];
    
    protected $dates = [
        'start',
        'end'
    ];

    public function categories (){
		return $this->belongsToMany(Category::class, 'promotion_category');
	}

	public function products(){
		return $this->belongsToMany(Product::class, 'promotion_product');
	}

}
