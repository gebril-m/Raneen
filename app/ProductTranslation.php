<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
class ProductTranslation extends Model
{
    protected $table = "product_translations";
    protected $fillable=['name','description','locale','product_id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function get_product($id){
    	return Product::find($id);
    }
}
