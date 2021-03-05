<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AttributeTranslation;
class AttributeProduct extends Model
{
    protected $table = "attribute_product";
    protected $fillable=['quantity','attribute_id','product_id'];

    public function get_attribute_name($id){
        $attrs_trans = AttributeTranslation::where('attribute_id','=',$id)->where('locale','=','en')->get()->first();
        if($attrs_trans){
            return $attrs_trans->name;
        }else{
            return '';
        }
    }
}
