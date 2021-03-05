<?php

namespace App\Imports;

use App\Brand;
use App\BrandTranslation;
use App\Category;
use App\CategoryTranslation;
use App\Manufacturer;
use App\ManufacturerTranslation;
use App\Product;
use App\ProductImage;
use App\ProductTranslation;
use Maatwebsite\Excel\Concerns\ToModel;
use App\ProductCategory;
use App\AttributeTranslation;
use App\AttributeProduct;
class ProductsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if($row[0] == 'Name') return NULL;
        if(!isset($row[0]) || !$row[0]) return NULL;



        $rules_validation=[];
        $product_trans_en = null;
        $product_trans_ar = ProductTranslation::whereName($row[0])
            ->whereLocale('ar')
            ->first();
        $product = new Product();


        $product_trans_en = ProductTranslation::whereName($row[1])
            ->whereLocale('en')
            ->first();

        if ($product_trans_ar) {
            $product = $product_trans_ar->product;
        }

        if ($product_trans_en) {
            $product = $product_trans_en->product;
        }

        if (!$product) {
            $product = new Product();
        }

        //dd($row[17].','.$row[19].','.$row[21]);
        $category_id            = Category::where('code',$row[17])->first()->id;
        $brand_id               = Brand::where('code',$row[19])->first()->id;
        //dd('hg');
       $manufacturer_id        = 36;

        try {
            $product->item_id       = $row[25];
            $product->barcode       = $row[23];
            $product->axapta_code       = $row[24];
        } catch (\Exception $exception) {
            # dd($product);
        }

        $product->brand_id      = $brand_id;
        $product->manufacturer_id      = $manufacturer_id;

        $product->minimum_stock          = $row[7] ?? 0;
        $product->stock          = $row[6] ?? 0;
        $product->price         = $row[8];
        if(isset($row[9])){
            $product->return_allowed = $row[9];
        }else{
            $product->return_allowed = 0;
        }
        if(isset($row[10])){
            $product->return_duration = $row[10];
        }else{
            $product->return_duration = 0;
        }
        if(isset($row[11])){
            $product->on_sale = $row[11];
        }else{
            $product->on_sale = 0;
        }
        if(isset($row[13])){
            $product->is_hot = $row[13];
        }else{
            $product->is_hot = 0;
        }
        if(isset($row[14])){
            $product->hot_price = $row[14];
        }else{
            $product->hot_price = 0;
        }
        if(isset($row[15]) && $row[15] != 0){
            $product->hot_starts_at=gmdate("Y-m-d H:i:s", strtotime($row[15]));
        }
        if(isset($row[16]) && $row[16] != 0){
            if (\DateTime::createFromFormat('Y-m-d H:i:s', $row[16]) == true) {
                //$end_date = ($row[17] - 25569) * 86400;
                $product->hot_ends_at = gmdate("Y-m-d H:i:s", strtotime($row[16]));//gmdate("Y-m-d H:i:s", $end_date);
            }else{
                $rules_validation[1]='The Date Format is not correct for hot starts at';
            }
        }
        // $product->return_policy         = $row[11] ?? '';
        $product->before_price         = isset($row[12])? $row[12]: 0;
        # $product->primary_vendor_id          = $row[5];
        $product->minimum_stock          = $row[7];
        $product->stock          = $row[6];
        $product->is_active          = isset($row[32])? $row[32]: 0;
        $product->is_point = isset($row[36])? $row[36]: 0;
        $product->save();

        $product_category = new ProductCategory;
        $product_category->product_id = $product->id;
        $product_category->category_id = $category_id;
        $product_category->save();


        if (!$product_trans_ar) {
            $product_trans_ar = new ProductTranslation();
        }
        $product_trans_ar->locale = 'ar';
        $product_trans_ar->name = $row[0];
        $product_trans_ar->product_id = $product->id;
        $product_trans_ar->slug = $row[2] ? $row[2] : '';
        $product_trans_ar->description = $row[4] ? $row[4] : '';
        $product_trans_ar->meta_title = $row[26];
        $product_trans_ar->meta_keywords = $row[27];
        $product_trans_ar->meta_description = $row[28];
        try {
            $product_trans_ar->save();
        } catch (\Exception $exception) {
             dd($exception);
        }

        if (!$product_trans_en) {
            $product_trans_en = new ProductTranslation();
        }
        $product_trans_en->locale = 'en';
        $product_trans_en->name = $row[1];
        $product_trans_en->product_id = $product->id;
        $product_trans_en->slug = $row[3] ? $row[3] : '';
        $product_trans_en->description = $row[5] ? $row[5] : '';
        $product_trans_en->meta_title = $row[29];
        $product_trans_en->meta_keywords = $row[30];
        $product_trans_en->meta_description = $row[31];
        try {
            $product_trans_en->save();
        } catch (\Exception $exception) {
            # dd($row);
        }
        if($row[33] != ''){
            $images = explode(',',$row[33]);
            if(is_array($images)){
                foreach ($images as $image) {
                    if(strpos($image,'http') !== false){
                        $image = $image;
                    }else{
                        $image = $image;
                    }
                    $product_image = new ProductImage;
                    $product_image->product_id = $product->id;
                    $product_image->image = $image;
                    $product_image->save();
                }
            }else{
                $product_image = new ProductImage;
                $product_image->product_id = $product->id;
                $product_image->image = $row[33];
                $product_image->save();
            }
        }
        if(isset($row[34]) && $row[34] != ''){
            $attrs = explode(',',$row[34]);
            $attrs_value = explode(',',$row[35]);
            $a=array_sum($attrs_value);
            if( $a> $product->stock){
                    $rules_validation[1]='The Stock Of '.$product->translate('ar')->name.' attributes canot be more than Product Stock ';

            }
            $i=0;
            foreach ($attrs as $attr) {

                $check_attr = AttributeTranslation::where('name','=',$attr)->where('locale','=','en')->get()->first();
                if($check_attr){
                    $attr_id = $check_attr->attribute_id;
                    $check_exist = AttributeProduct::where('product_id','=',$product->id)->where('attribute_id','=',$attr_id)->get()->first();
                    if($check_exist){

                            $check_exist->quantity = $attrs_value[$i];


                    }else{
                        $new_attr_product = new AttributeProduct;
                        $new_attr_product->product_id = $product->id;
                        $new_attr_product->quantity = $attrs_value[$i];

                        $new_attr_product->attribute_id = $attr_id;
                        $new_attr_product->save();
                    }
                }

                $i++;
            }
        }
        if (count($rules_validation)) {
            session()->flash('rules_validation',$rules_validation);

            return NULL;
        }


//        return $product;
//        return new Product([
//            # 'category_id' => request()->get('category_id'),
//            'brand_id' => request()->get('brand_id'),
//            'name'     => $row[0],
//            'email'    => $row[1],
//            'password' => \Hash::make('123456'),
//        ]);
    }

    private function getManufacturer($row) {
        $manufacturer_ar = ManufacturerTranslation::whereName($row[21])
            ->whereLocale('ar')
            ->first();

        $manufacturer_id = 0;

        if ($manufacturer_ar) {
            $manufacturer_id = $manufacturer_ar->manufacturer_id;
        } else if ($row[21]) {
            $manufacturer_ar = new ManufacturerTranslation();
            $manufacturer_ar->locale = 'ar';
            $manufacturer_ar->name = $row[21];
            $manufacturer_ar->slug = $row[21];
        }

        $manufacturer_en = ManufacturerTranslation::whereName($row[22])
            ->whereLocale('en')
            ->first();

        if ($manufacturer_en) {
            $manufacturer_id = $manufacturer_en->manufacturer_id;
        } else if ($row[22]) {
            $manufacturer_en = new ManufacturerTranslation();
            $manufacturer_en->locale = 'en';
            $manufacturer_en->name = $row[22];
            $manufacturer_en->slug = $row[22];
        }

        if (!$manufacturer_id) {
            $manufacturer = new Manufacturer();
            $manufacturer->logo = '';
            $manufacturer->save();

            $manufacturer_id = $manufacturer->id;
            if ($manufacturer_en) {
                $manufacturer_en->manufacturer_id = $manufacturer_id;
                $manufacturer_en->save();
            }
            if($manufacturer_ar) {
                $manufacturer_ar->manufacturer_id = $manufacturer_id;
                $manufacturer_ar->save();
            }
        }

        return $manufacturer_id;
    }

    private function getBrand($row) {
        $brand_ar = BrandTranslation::whereName($row[19])
            ->whereLocale('ar')
            ->first();

        $brand_id = 0;

        if ($brand_ar) {
            $brand_id = $brand_ar->brand_id;
        } else {
            $brand_ar = new BrandTranslation();
            $brand_ar->locale = 'ar';
            $brand_ar->name = $row[19];
            // $brand_ar->slug = $row[19];
        }

        $brand_en = BrandTranslation::whereName($row[20])
            ->whereLocale('en')
            ->first();

        if ($brand_en) {
            $brand_id = $brand_en->brand_id;
        } else {
            $brand_en = new BrandTranslation();
            $brand_en->locale = 'en';
            $brand_en->name = $row[20];
            // $brand_en->slug = $row[20];
        }

        if (!$brand_id) {
            $brand = new Brand();
            $brand->save();

            $brand_id = $brand->id;
            $brand_ar->brand_id = $brand_id;
            $brand_en->brand_id = $brand_id;
            $brand_ar->save();
            $brand_en->save();
        }

        return $brand_id;
    }

    private function getCategory($row) {
        // OLD CODE
        // $category_ar = CategoryTranslation::whereName($row[17])
        //     ->whereLocale('ar')
        //     ->first();

        // $category_id = 0;

        // if ($category_ar) {
        //     $category_id = $category_ar->category_id;
        // } else {
        //     $category_ar = new CategoryTranslation();
        //     $category_ar->locale = 'ar';
        //     $category_ar->name = $row[17];
        //     $category_ar->slug = $row[17];
        // }

        // $category_en = CategoryTranslation::whereName($row[18])
        //     ->whereLocale('en')
        //     ->first();

        // if ($category_en) {
        //     $category_id = $category_en->category_id;
        // } else {
        //     $category_en = new CategoryTranslation();
        //     $category_en->locale = 'en';
        //     $category_en->name = $row[18];
        //     $category_en->slug = $row[18];
        // }

        // if (!$category_id) {
        //     $category = new Category();
        //     $category->save();

        //     $category_id = $category->id;
        //     $category_ar->category_id = $category_id;
        //     $category_en->category_id = $category_id;
        //     $category_ar->save();
        //     $category_en->save();
        // }

        // Modified Code
        $category_id = 0;
        $category_ar = CategoryTranslation::where('name','=',$row[17])
            ->where('locale','=','ar')
            ->get();
        $category_en = CategoryTranslation::where('name','=',$row[18])
            ->where('locale','=','en')
            ->get();

        if(count($category_ar) > 0 || count($category_en) > 0){
            if(count($category_ar) > 0){
                $category_id = $category_ar[0]->category_id;
            }
            if(count($category_en) > 0){
                $category_id = $category_en[0]->category_id;
            }
            $get_category = Category::find($category_id);
            if(!isset($get_category)){
                $category = new Category();
                $category->id = $category_id;
                $category->parent_id = 0;
                $category->is_active = 1;
                $category->in_header = 0;
                $category->save();
                $category_id = $category->id;
            }
        }else{
            $category = new Category();
            $category->parent_id = 0;
            $category->is_active = 1;
            $category->in_header = 0;
            $category->save();
            $category_id = $category->id;
        }
        $category_ar = CategoryTranslation::where('category_id','=',$category_id)->where('locale','=','ar')->get()->first();
        $category_en = CategoryTranslation::where('category_id','=',$category_id)->where('locale','=','en')->get()->first();

        $check_ar_slug = CategoryTranslation::where('slug','=',$row[17])->get();
        $check_en_slug = CategoryTranslation::where('slug','=',$row[18])->get();
        if(count($check_ar_slug) < 1){
            if($category_ar){
                $category_ar->name = $row[17];
                $category_ar->slug = $row[17];
                $category_ar->meta_title = $row[17];
                $category_ar->meta_keywords = $row[17];
                $category_ar->meta_description = $row[17];
                $category_ar->save();
            }else{
                $category_ar = new CategoryTranslation;
                $category_ar->name = $row[17];
                $category_ar->slug = $row[17];
                $category_ar->category_id = $category_id;
                $category_ar->locale = "ar";
                $category_ar->meta_title = $row[17];
                $category_ar->meta_keywords = $row[17];
                $category_ar->meta_description = $row[17];
                $category_ar->save();
            }
        }
        if(count($check_en_slug) < 1){
            if($category_en){
                $category_en->name =  $row[18];
                $category_en->slug = $row[18];
                $category_en->meta_title = $row[18];
                $category_en->meta_keywords = $row[18];
                $category_en->meta_description = $row[18];
                $category_en->save();
            }else{
                $category_en = new CategoryTranslation;
                $category_en->name = $row[18];
                $category_en->slug = $row[18];
                $category_en->category_id = $category_id;
                $category_en->locale = "en";
                $category_en->meta_title = $row[18];
                $category_en->meta_keywords = $row[18];
                $category_en->meta_description = $row[18];
                $category_en->save();
            }
        }

        return $category_id;
    }
}
