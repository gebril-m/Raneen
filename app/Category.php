<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\CategoryTranslation;
class Category extends Model
{
    use Translatable ;
    public $translatedAttributes = ['slug', 'name', 'body'];
    protected $fillable = ['is_active','in_header','code'];
    protected $hidden = ['created_at','updated_at'];

    public function getUrlAttribute()
    {
        return route_lang('web.categories.products.search', $this->slug);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail(768, 988);
    }

    public function get_seo($lang,$column,$id){
        $product = CategoryTranslation::where('locale','=',$lang)->where('category_id','=',$id)->get()->first();
        if(!$product){
            return '';
        }else{
            return $product->$column;
        }
    }
    public function thumbnail($x, $y) {
        $image = $this->icon;
        return thumb('category', $x, $y, $image);
    }

    public function getIconUrlAttribute()
    {
        return image('category', $this->icon);
    }

    public function icon_url($x, $y)
    {
        return thumb('category', $x, $y, $this->icon);
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class, 'attribute_category');
    }

    public function cupons (){
		return $this->belongsToMany(Cupon::class);
	}
    // for first level child this will works enough

    // and here is the trick for nestable child.
    public static function nestable($categories) {
        foreach ($categories as $category) {
            if (!$category->children->isEmpty()) {
                $category->children = self::nestable($category->children);
            }
        }

        return $categories;
    }

    public function promotions (){
        return $this->belongsToMany(Promotion::class, 'promotion_category');
    }

    public function getProductIdsAttribute()
    {
        return $this->products->pluck('id')->toArray();
    }
}
