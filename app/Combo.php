<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    protected $fillable=['name_ar','name_en','status'];

    public function values()
    {
    	return $this->hasMany(ComboValue::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function getCategoryIdsAttribute()
    {
        return $this->categories->pluck('id')->toArray();
    }
    public function getProductIdsAttribute()
    {
        return $this->products->pluck('id')->toArray();
    }
}
