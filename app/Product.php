<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\ProductImage;
use App\ProductTranslation;
use App\AttributeProduct;
use App\MainSetting;
use App\DealSection;

class Product extends Model
{
     use Translatable ;

    public $translatedAttributes = ['name', 'description','slug'];
    protected $fillable = ['is_active','return_allowed','return_duration','price','stock','minimum_stock','on_sale','is_bundle','before_price','bundle_start','bundle_end','bundle_image'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['added_to_wishlist', 'added_to_cart'];

    public function discount_priority(){
        $setting = MainSetting::where('key','=','discount_priority')->get()->first();
        $high = 0;
        $low = 0;
        $old = 0;
        $new = 0;
        $oldest = '';
        $newest = '';
        if($setting){
            $discounts = $this->get_all_discounts();
            foreach (json_decode($discounts) as $key => $value) {
                if($high == 0 && $low == 0){
                    $high = $value;
                    $low = $value;
                }else{
                    if($value > $high){
                        $high = $value;
                    }
                    if($value < $low){
                        $low = $value;
                    }
                }
                if($key == 'on_sale'){
                    $product = Product::find($this->id);
                    if($oldest == 0 && $newest == 0){
                        $oldest = $product->sale_ends_at;
                        $newest = $product->sale_ends_at;
                        $old = $value;
                        $new = $value;
                    }
                    if($product->sale_ends_at < $oldest){
                        $oldest = $product->sale_ends_at;
                        $old = $value;
                    }
                    if($product->sale_ends_at > $newest){
                        $newest = $product->sale_ends_at;
                        $new = $value;
                    }
                }
                if($key == 'deal_section'){
                    $dealsections = DealSection::where('end_date','<',date('Y-m-d'))->get();
                    foreach($dealsections as $ds){
                        $products = explode(',',$ds->product_ids);
                        if(in_array($this->id, $products)){
                            if($oldest == 0 && $newest == 0){
                                $oldest = $ds->start_date;
                                $newest = $ds->start_date;
                                $old = $value;
                                $new = $value;
                            }
                            if($ds->start_date < $oldest){
                                $oldest = $ds->start_date;
                            $old = $value;
                            }
                            if($ds->start_date > $newest){
                                $newest = $ds->start_date;
                            $new = $value;
                            }
                        }
                    }
                }
                if($key == 'hot_deal'){
                    $product = Product::find($this->id);
                    if($oldest == 0 && $newest == 0){
                        $oldest = $product->hot_starts_at;
                        $newest = $product->hot_starts_at;
                        $old = $value;
                        $new = $value;
                    }
                    if($product->hot_starts_at < $oldest){
                        $oldest = $product->hot_starts_at;
                        $old = $value;
                    }
                    if($product->hot_starts_at > $newest){
                        $newest = $product->hot_starts_at;
                        $new = $value;
                    }
                }
            }
            if($setting->value == 'high_discount'){
                return $high;
            }
            if($setting->value == 'low_discount'){
                return $low;
            }
            if($setting->value == 'old'){
                return $old;
            }
            if($setting->value == 'new'){
                return $new;
            }
        }
    }
    public function get_all_discounts(){
        $discounts = [];
        $product = Product::find($this->id);
        $dealsections = DealSection::where('end_date','>',date('Y-m-d'))->get();
        foreach($dealsections as $ds){
            $products = explode(',',$ds->product_ids);
            if(in_array($this->id, $products)){
                $discounts['deal_section'] = $ds->discount;
            }
        }
        if($product->on_sale == 1){
            $discounts['on_sale'] = $this->discount_number($product->price,$product->before_price);
        }
        if($product->is_hot == 1){
            $discounts['hot_deal'] = $this->discount_number($product->hot_price,$product->before_price);
        }
        return json_encode($discounts);
    }
    public function getThumbnailUrlAttribute() {

        $image = $this->thumbnail;
        if (!$image) {
            $images = $this->images;
            if (sizeof($images) > 0) {
                $image = $images[0];
                return thumb('product', 768, 988, $image->image);
            }
            return asset('/assets/images/layout-2/media-banner/1.jpg');
        }
        return thumb('product', 768, 988, $image);

    }
    public function discount($id){
        $product = Product::find($id);
        if($product){
            $total = (int)$product->before_price;
            $number = $product->before_price-$product->price;
            $number = str_replace("-", "", $number);
            if($total){
                $discount = round(($number/$total)*100);
                return $discount."%";
            }
        }
    }
    public function discount_number($price,$before){
        $total = (int)$before;
        $number = $before-$price;
        $number = str_replace("-", "", $number);
        if($total){
            $discount = round(($number/$total)*100);
            return $discount;
        }
    }
    public function thumbnail($x, $y) {
        $image = $this->thumbnail;

        if (!$image) {
            $images = $this->images;
            if (sizeof($images) > 0) {
                $image = $images[0];
                return thumb('product', $x, $y, $image->image);
            }
            return asset('/assets/images/layout-2/media-banner/1.jpg');
        }

        return thumb('product', $x, $y, $image);
        return asset('/assets/images/layout-2/media-banner/1.jpg');
    }
    public function get_bundle_images($id){
        $products_arr = [];
        $bundle_products = BundleProduct::where('bundle_id','=',$id)->get();
        foreach($bundle_products as $bp){
            array_push($products_arr,$bp->product_id);
        }
        $images = ProductImage::whereIn('product_id',$products_arr)->get();
        return $images;
    }

    public function checkBundleItemsStock($id){
        $check_sub = BundleProduct::where('bundle_id','=',$id)->get();
        $quantity=1;
        $productStock =[];
        $status=[];

        foreach($check_sub as $item){ 
            $stockAvailable = $this->checkStock($item->product_id,$quantity);
            $stockQuantity = $this->checkStockQuantity($item->product_id);
            
            if(!$stockAvailable['status']){ 
                $productStock[] = $stockQuantity['bundleQuantity'];
                $status[] = 'fail';
            }else{
                $productStock[] = $stockQuantity['bundleQuantity'];
                $status[] = 'true';
            }
 
        }
        
        return ['status' => (in_array("fail", $status) ? 'fail' : 'true' ), 'productBundleStock' => min($productStock)];
         
    }

    public function checkStockQuantity($id){
        //echo $id; die();
        $product = Product::find($id);
        if($product){
            return [
                'bundleQuantity' => $product->stock
            ];
        }else{
            return [
                'bundleQuantity' => 0 
            ];
        } 
    }

    public function checkStock($id,$qty){

        $productStock = Product::find($id);
        if($productStock){
            return [
                'status' => ($productStock->stock >= $qty) ? 1 : 0 
            ];
        }else{
            return [
                'status' => 0 
            ];
        }

    }

    public function get_my_bundle_images($id){
        $products_images = [$this->bundle_image];
        $bundle_products = BundleProduct::where('bundle_id','=',$id)->get();
        foreach($bundle_products as $bp){
        $image = ProductImage::where('product_id',$bp->product_id)->first()->image;
            array_push($products_images,$image);
        }
        return $products_images;
    }
    public function get_images($id){
        $images_obj = [];
        $product = Product::find($id);
        if($product->thumbnail != null){
            array_push($images_obj,$product->thumbnail);
        }
        $images = ProductImage::where('product_id','=',$id)->get();
        foreach ($images as $image) {
            array_push($images_obj, $image->image);
        }
        if (count($images_obj)>0) {
            return $images_obj;
        }
        return ['cam8.jpg'];
    }
    public function get_image($id){
        $images_obj = [];
        $product = Product::find($id);
        if($product->thumbnail != null){
            array_push($images_obj,$product->thumbnail);
        }
        $images = ProductImage::where('product_id','=',$id)->get();
        foreach ($images as $image) {
            array_push($images_obj, $image->image);
        }
        if (count($images_obj)>0) {
            return $images_obj[0];
        }
        return 'cam8.jpg';
    }
    public function get_seo($lang,$column,$id){
        $product = ProductTranslation::where('locale','=',$lang)->where('product_id','=',$id)->get()->first();
        if(!$product){
            return '';
        }else{
            return $product->$column;
        }
    }
    public function get_product($id){
        return Product::find($id);
    }
    public function getUrlAttribute() {
        return route('web.products.show', ['slug'=>$this->slug]);
    }
    public function check_return($product,$order){
        $check = OrderProduct::where('product_id','=',$product)->where('order_id','=',$order)->get()->first();
        return  $check->is_return;
    }
    public function check_return_date($product,$order){
        $check = OrderProduct::where('product_id','=',$product)->where('order_id','=',$order)->get()->first();
        return  $check->return_date;
    }

    public function getUrlLangAttribute() {
        return url_lang(route('web.products.show', $this->slug), app()->getLocale());
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function manufacturer() {
        return $this->belongsTo(Manufacturer::class);
    }

    public function cupons (){
        return $this->belongsToMany(Cupon::class);
    }

    public function attributes (){
        return $this->belongsToMany(Attribute::class)->withPivot('value','quantity','price','picture','code');
    }
    public function attributes_without_pivot (){
        return $this->belongsToMany(Attribute::class);
    }

    public function images (){
        return $this->hasMany(ProductImage::class);
    }

    public function options (){
        return $this->belongsToMany(Option::class);
    }

    public function promotions (){
        return $this->belongsToMany(Promotion::class, 'promotion_product');
    }

    public function reviews (){
        return $this->hasMany(Review::class, 'item_id', 'id');
    }

    public function get_reviews (){
        return Review::where('item_id','=',$this->id)->where('approved','=',1)->latest()->get();
    }
    public function scopeReviewsDetails(){
        return $this->reviews()
                    ->where('approved','=',1)
                    ->selectRaw('COUNT(rate) as ratesCount, (COUNT(rate)/SUM(rate))*5 as rateAvg')
                    ->get();
    }

    public function getRateAvg(){
        $rate = Review::query()

            ->selectRaw("count(case when rate = 5 then 1 end) as five_stars")
            ->selectRaw("count(case when rate = 4 then 1 end) as four_stars")
            ->selectRaw("count(case when rate = 3 then 1 end) as three_stars")
            ->selectRaw("count(case when rate = 2 then 1 end) as two_stars")
            ->selectRaw("count(case when rate = 1 then 1 end) as one_star")
            ->where('item_id','=',$this->id)
            ->where('approved','=',1)
            ->first();
        $all=0;

        $one_star = $rate->one_star * 1;
        $two_stars = $rate->two_stars * 2;
        $three_stars = $rate->three_stars * 3;
        $four_stars = $rate->four_stars * 4;
        $five_stars = $rate->five_stars * 5;

        $all = $one_star + $two_stars + $three_stars + $four_stars + $five_stars;

        $all_c = Review::Where('item_id','=',$this->id)->where('approved','=',1)->get()->count();


        if($all > 0){
            $all_counts = $all/$all_c;

            return floor($all_counts);

        }else{
            return '0';
        }
    }
    public function get_category(){
        $category = ProductCategory::where('product_id','=',$this->id)->get()->first();
        $category = Category::find($category->category_id);
        return $category;
    }
    public function get_attrs_child($id,$arr){
        $attributes = Attribute::where('group_id','=',$id)->get();
        $product_attrs = [];
        $selected_attrs = [];
        foreach($arr as $ar){
            array_push($product_attrs,$ar->id);
        }
        foreach($attributes as $attribute){
            if(in_array($attribute->id,$product_attrs)){
                array_push($selected_attrs,$attribute->id);
            }
        }
        $final = Attribute::whereIn('id',$selected_attrs)->get();
        return $final;
    }
    public function getProductPriceAttribute() {

        $productPromotion = $this->promotions;
        $productHasPromtion = 0;
        $promotion = '';
        if($productPromotion->count() != 0){
            $promotion = $productPromotion[0];
            $productHasPromtion = $promotion->end->isPast() ? 0 : 1;
        }

        if($productHasPromtion) {
            $originalPrice = $this->price;
            if ($promotion->type == 'p') {
                $newPrice = $originalPrice - (($originalPrice * $promotion->amount) / 100);
            } else if ($promotion->type == 'f') {
                $newPrice = $originalPrice - $promotion->amount;
            }

            return number_format($newPrice, 2);
        }

        $categories = $this->categories;
        foreach ($categories as $category) {
            $promotions = $category->promotions;
            if ($promotions->count() > 0) {
                foreach ($promotions as $promotion) {
                    if (!$promotion->end->isPast()) {
                        $originalPrice = $this->price;
                        if ($promotion->type == 'p') {
                            $newPrice = $originalPrice - (($originalPrice * $promotion->amount) / 100);
                        } else if ($promotion->type == 'f') {
                            $newPrice = $originalPrice - $promotion->amount;
                        }
                        return number_format($newPrice, 2);
                    }
                }
            }
        }

        return $this->price;
    }


    public function getProductBeforePriceAttribute() {
        if ($this->on_sale) return $this->before_price;

        $productPromotion = $this->promotions;
        $productHasPromtion = 0;
        $promotion = '';
        if($productPromotion->count() != 0){
            $promotion = $productPromotion[0];
            $productHasPromtion = $promotion->end->isPast() ? 0 : 1;
        }

        if($productHasPromtion) {
            return $this->price;
        }

        return 0;
    }

    public function scopeProductsApi($query){
        return $query->select('id', 'thumbnail', 'brand_id', 'before_price', 'price', 'up_selling', 'on_sale', 'is_hot', 'is_bundle')
                     ->with('translations:locale,id,product_id,name,slug')
                     ->with('brand:id,logo')
                     ->with('brand.translations:id,brand_id,locale,name')
                     ->with('attributes:id')
                     ->with('attributes.translations:attribute_id,locale,name')
                     ->with('categories:id,parent_id, icon, banner')
                     ->with('categories.translations:id,category_id,name,slug')
                     ->with('images:product_id,image');
                     // ->where('stock', '>', 0);
    }

    public function getAddedToWishlistAttribute($value)
    {
        return 0;
        if(session()->has('products.wishlist.'.$this->id)) {
            return $this->attributes['added_to_wishlist'] = session()->get('products.wishlist');
        } else {
            return $this->attributes['added_to_wishlist'] = session()->get('products.wishlist');
        }
    }

    public function getAddedToCartAttribute($value)
    {
        return 0;
        if(session()->has('products.cart.'.$this->id)){
            return $this->attributes['added_to_cart'] = 1;
        } else {
            return $this->attributes['added_to_cart'] = 0;
        }
    }

    public function getRelatedProductsAttribute() {
        $top_cat = ProductCategory::where('product_id', $this->id)->orderBy('id', 'DESC')->first();
        if(!$top_cat) return [];
        $related_products = Product::join('product_categories', 'product_categories.product_id', 'products.id')
            ->select('products.*')
            ->where('product_categories.category_id', $top_cat->category_id)
            ->where('products.id', '!=', $this->id)
            ->where('products.is_active', true)
            ->limit(10)
            ->get();

        return $related_products;
    }

    public function inventories() {
        return $this->belongsToMany(Inventory::class, 'inventory_products')->withPivot('id', 'quantity');
    }
    public function get_attributes($id){
        $attrs = AttributeProduct::where('product_id','=',$id)->get();

        $attrs_obj = [];
        foreach ($attrs as $attr) {
            array_push($attrs_obj, $attr->get_attribute_name($attr->attribute_id));
        }
        return $attrs_obj;
    }
    public function get_attr($arr){
        $arr = explode(",",$arr);
        if(count($arr) > 0){
            return Attribute::whereIn('id',$arr)->get();
        }else{
            return "";
        }
    }
    public function get_attributes_value($id){

        $attrs = AttributeProduct::where('product_id','=',$id)->get();

        $attrs_obj = [];
        foreach ($attrs as $attr) {
            array_push($attrs_obj, $attr->quantity);
        }
        return $attrs_obj;
    }
    public function get_discount_bundle_product($combo_id,$product_id){
        $in_combo = BundleProduct::where('bundle_id','=',$combo_id)->where('product_id','=',$product_id)->get()->first();
        $discount = $in_combo->discount;
        $product = Product::find($product_id);
        $discount_value = ((int)$product->price*(int)$discount)/100;
        $after_discount = $product->price-$discount_value;
        return [$discount,$product->price,$after_discount];
    }
    public function get_bundle_products($id){
        $product_obj = [];
        $bundle_details = BundleProduct::where('bundle_id','=',$id)->orderBy('id','asc')->get();
        foreach($bundle_details as $bundle){
            array_push($product_obj,$bundle->product_id);
        }
        return Product::whereIn('id',$product_obj)->get();

    }
    public function get_bundle_products_images($id){
        $product_obj = [];
        $image_obj = [];
        $bundle_details = BundleProduct::where('bundle_id','=',$id)->get();
        foreach($bundle_details as $bundle){
            array_push($product_obj,$bundle->product_id);
        }
        $products = Product::whereIn('id',$product_obj)->get();
        foreach($products as $product){
            foreach($product->images as $image){
                array_push($image_obj,$image->image);
            }
        }
        return json_encode($image_obj);

    }
    public function get_bundle_products_image($id){
        $product_obj = [];
        $image_obj = [];
        $bundle_details = BundleProduct::where('bundle_id','=',$id)->get();
        foreach($bundle_details as $bundle){
            array_push($product_obj,$bundle->product_id);
        }
        $products = Product::whereIn('id',$product_obj)->get();
        foreach($products as $product){
            foreach($product->images as $image){
                array_push($image_obj,$image->image);
            }
        }
        if (count($image_obj)>0) {

        return $image_obj[0];
        }
        return 'cam8.jpg';

    }

    public function combos()
    {
        return $this->belongsToMany(Combo::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Cupon::class);
    }

    public function getComboIdsAttribute()
    {
        return $this->combos->pluck('id')->toArray();
    }

    public function get_my_bundle()
    {
        $rel=BundleProduct::where('product_id',$this->id)->get();
        if(count($rel)>0){
            return $rel;
        }
        return false;
    }

    public  function getFinalPriceAfterDiscountPriroty()
    {
        $offer=get_product_priroty_array($this->id);
        #promotion
        if (count($this->promotions()->get()) > 0) {
            if ($offer['promotion_order_id']==min($offer)) {
                $promotion=$this->promotions()->first();
                if ($promotion->type=='p') {
                    if ($this->before_price>0) {
                        $price=$this->before_price-$this->before_price*$promotion->amount/100;
                    }else{
                        $price=$this->price-$this->price*$promotion->amount/100;
                    }
                }else{
                    if ($this->before_price>0) {
                        $price=$this->before_price-$promotion->amount;
                    }else{
                        $price=$this->price-$promotion->amount;
                    }

                }
                return $price;
            }
        }
        #bundle
        if ($this->is_bundle) {
            if ($offer['bundle_order_id']==min($offer)) {
                return $this->price;
            }
        }
        #On Sale
        if ($this->on_sale) {
            if ($offer['on_sale_order_id']==min($offer)) {
                return $this->price;
            }
        }
        #IS HOT
        if ($this->is_hot) {
            if ($offer['hot_order_id']==min($offer)) {
                return $this->price;
            }
        }

        return $this->price;
    }

    public function is_offer()
    {
        if (count($this->promotions()->get()) > 0) {
            return true;
        }


        if ($this->is_bundle==1) {
            return true;
        }

        if ($this->is_hot || $this->on_sale) {
            return true;
        }
        if ($this->before_price>0) {
            return true;
        }
        if (has_cupon($this->id)) {
            return true;
        }
        return false;
    }

    public  function getFinalDiscountPriroty()
    {
        if ($this->is_offer()) {
            # code...

             $offer=get_product_priroty_array($this->id);
            #promotion
            if (count($this->promotions()->get()) > 0) {
                if ($offer['promotion_order_id']==min($offer)) {
                    $promotion=$this->promotions()->first();
                    if ($promotion->type=='p') {
                        if ($this->before_price>0) {
                            $price=$this->before_price*$promotion->amount/100;
                        }else{
                            $price=$this->price*$promotion->amount/100;
                        }
                    }else{
                        if ($this->before_price>0) {
                            $price=$promotion->amount;
                        }else{
                            $price=$promotion->amount;
                        }

                    }
                    return $price;
                }
            }
            #bundle
            if ($this->is_bundle) {
                if ($offer['bundle_order_id']==min($offer)) {
                    return abs($this->price-$this->before_price);
                }
            }
            #On Sale
            if ($this->on_sale) {
                if ($offer['on_sale_order_id']==min($offer)) {
                    return abs($this->price-$this->before_price);
                }
            }
            #IS HOT
            if ($this->is_hot) {
                if ($offer['hot_order_id']==min($offer)) {
                    return abs($this->hot_price-$this->price);
                }
            }
            if ($this->before_price>0) {

                    return abs($this->price-$this->before_price);

            }

        }else{
            return 0;
        }
        return 0;
    }
    public  function getFinalOldPricePriroty()
    {
        if ($this->is_offer()) {
            # code...

             $offer=get_product_priroty_array($this->id);
            #promotion
            if (count($this->promotions()->get()) > 0) {
                if ($offer['promotion_order_id']==min($offer)) {
                    $promotion=$this->promotions()->first();
                    if ($promotion->type=='p') {
                        if ($this->before_price>0) {
                            $price=$this->before_price+$this->before_price*$promotion->amount/100;
                        }else{
                            $price=$this->price+$this->price*$promotion->amount/100;
                        }
                    }else{
                        if ($this->before_price>0) {
                            $price=$this->before_price+$promotion->amount;
                        }else{
                            $price=$this->price+$promotion->amount;
                        }

                    }
                    return $price;
                }
            }
            #bundle
            if ($this->is_bundle) {
                if ($offer['bundle_order_id']==min($offer)) {
                    return $this->before_price;
                }
            }
            #On Sale
            if ($this->on_sale) {
                if ($offer['on_sale_order_id']==min($offer)) {
                    return $this->before_price;
                }
            }
            #IS HOT
            if ($this->is_hot) {
                if ($offer['hot_order_id']==min($offer)) {
                    return $this->hot_price;
                }
            }

            if ($this->before_price>0) {

                    return $this->before_price;

            }
        }else{
            return '';
        }
    }

    public function product_of_bundle($product_id,$bundle_id)
    {
        if($product=\App\BundleProduct::where('product_id',$product_id)->where('bundle_id',$bundle_id)->first()){
            return $product;
        }else{
            return null;
        }
    }

    public function offer_flag()
    {
        if ($this->is_offer()) {
            # code...

             $offer=get_product_priroty_array($this->id);
            #promotion
            if (count($this->promotions()->get()) > 0) {
                if ($offer['promotion_order_id']==min($offer)) {
                    return 'promotion';
                }
            }
            #bundle
            if ($this->is_bundle==1) {
                if ($offer['bundle_order_id']==min($offer)) {
                    return 'bundle';
                }
            }
            #On Sale
            if ($this->on_sale==1) {
                if ($offer['on_sale_order_id']==min($offer)) {
                    return 'On Sale';
                }
            }
            #IS HOT
            if ($this->is_hot==1) {
                if ($offer['hot_order_id']==min($offer)) {
                    return 'Hot Product';
                }
            }

        }else{
            return false;
        }
        return false;
    }

}
