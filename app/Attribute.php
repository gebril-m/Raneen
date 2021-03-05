<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\AttributeProduct;
class Attribute extends Model
{

    use Translatable;
    
    public $translatedAttributes = ['name'];

    protected $fillable = [
        'group_id', 
        'is_active'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    function parentRow(){
        return $this->belongsTo(Attribute::class, 'group_id', 'id');
    }

    function childrensRow(){
        return $this->hasMAny(Attribute::class, 'group_id', 'id');
    }

    function scopeParents($query){
        return $query->where('group_id', null);
    }

    function scopeChildrens($query){
        return $query->where('group_id', '!=', null);
    }
    function attr($group,$attr){
        $attribute = Attribute::find($attr);
        if($attribute){
            if(isset($attribute) && $attribute->group_id == $group){
                return $attribute;
            }
        }
    }
    function product($product,$attr){
        return AttributeProduct::where('product_id','=',$product)->where('attribute_id','=',$attr)->get()->first();
    }
    function categories(){
        return $this->belongsToMany(Category::class,'attribute_category');
    }
    function getCategoriesId(){
        return $this->categories->pluck('id')->toArray();
    }
}
