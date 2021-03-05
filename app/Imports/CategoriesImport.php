<?php

namespace App\Imports;

use App\Category;
use App\CategoryTranslation;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoriesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if($row[1] == 'Name') return;

//        $Category                = new Category();
//        $category->name          = $row[0];
//        $category->save();
//
//        $Category_translation                = new CategoryTranslation();
//        $Category_translation->name          = $row[1];
//        $Category_translation->locale          = 'en';
//        $Category_translation->category_id          = $category->id;
//        $Category_translation->save();
        $parent = $row[5];
        $name_ar = $row[3];
        $name_en = $row[4];
        $check_ar = CategoryTranslation::where('slug','=',$name_ar)->get();
        $check_en = CategoryTranslation::where('slug','=',$name_en)->get();
        $icon = $row[12];
        if($icon){
            if(strpos($icon,'http') !== false){
                $icon = $row[12];
            }else{
                $icon = $row[12];
            }
        }
        if(count($check_ar) > 0 || count($check_en) > 0){
            return;
        }
        if($parent){
            $parent_en = CategoryTranslation::where('slug','=',$parent)
            ->where('locale','=','en')
            ->get();
            if(count($parent_en) > 0){
                $parent_value = $parent_en[0]->category_id;
            }else{
                // $new_parent = new Category;
                // $new_parent->parent_id = 0;
                // $new_parent->is_active = 0;
                // $new_parent->in_header = 0;
                // $new_parent->banner = '';
                // $new_parent->icon = '';
                // $new_parent->code=rand();
                // $new_parent->save();
                // $parent_value = $new_parent->id;
                // $new_parent_category = new CategoryTranslation;
                // $new_parent_category->category_id = $new_parent->id;
                // $new_parent_category->locale = 'en';
                // $new_parent_category->name = $row[4];
                // $new_parent_category->slug = $row[4].'-en';
                // $new_parent->code=rand(); 
                // $new_parent_category->save();
                // $new_parent_category = new CategoryTranslation;
                // $new_parent_category->category_id = $new_parent->id;
                // $new_parent_category->locale = 'ar';
                // $new_parent_category->name = $row[4];
                // $new_parent_category->slug = $row[4]; 
                // $new_parent->code=rand();
                // $new_parent->save();
                $parent_value = 0;
            }
        }else{
            $parent_value = 0;
        }
        $Category_obj = [];
        $category_id = 0;
        $category_ar = CategoryTranslation::where('name','=',$row[1])
            ->where('locale','=','ar')
            ->get();
        $category_en = CategoryTranslation::where('name','=',$row[2])
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
            if(isset($get_category)){
                if(isset($row[13])){
                    $get_category->is_active = $row[13];
                }else{
                    $get_category->is_active = 0;
                }
                if(isset($row[14])){
                    $get_category->in_header = $row[14];
                }else{
                    $get_category->in_header = 0;
                }
                $get_category->banner = $icon;
                $get_category->code=$row[0];
                $get_category->save();
            }else{
                $category = new Category();
                $category->id = $category_id;
                $category->parent_id = $parent_value;
                if(isset($row[13])){
                    $category->is_active = $row[13];
                }else{
                    $category->is_active = 0;
                }
                if(isset($row[14])){
                    $category->in_header = $row[14];
                }else{
                    $category->in_header = 0;
                }
                $category->banner = $icon;
                $category->code=$row[0];
                $category->save();
                $category_id = $category->id;
            }
        }else{
            $category = new Category();
            $category->parent_id = $parent_value;
            $category->banner = $icon;
            if(isset($row[13])){
                $category->is_active = $row[13];
            }else{
                $category->is_active = 0;
            }
            if(isset($row[14])){
                $category->in_header = $row[14];
            }else{
                $category->in_header = 0;
            }
            $category->code=$row[0];
            $category->save();
            $category_id = $category->id;
        }   
        $category_ar = CategoryTranslation::where('category_id','=',$category_id)->where('locale','=','ar')->get()->first(); 
        $category_en = CategoryTranslation::where('category_id','=',$category_id)->where('locale','=','en')->get()->first();

        $check_ar_slug = CategoryTranslation::where('slug','=',$row[3])->get();
        $check_en_slug = CategoryTranslation::where('slug','=',$row[4])->get();
        if(count($check_ar_slug) < 1){
            if($category_ar){
                $category_ar->name = $row[1];
                $category_ar->slug = $row[3];
                $category_ar->meta_title = $row[6];
                $category_ar->meta_keywords = $row[7];
                $category_ar->meta_description = $row[8];
                $category_ar->save();
            }else{
                $category_ar = new CategoryTranslation;
                $category_ar->name = $row[1];
                $category_ar->slug = $row[3];
                $category_ar->category_id = $category_id;
                $category_ar->locale = "ar";
                $category_ar->meta_title = $row[6];
                $category_ar->meta_keywords = $row[7];
                $category_ar->meta_description = $row[8];
                $category_ar->save();
            }    
        }
        if(count($check_en_slug) < 1){
            if($category_en){
                $category_en->name =  $row[2];
                $category_en->slug = $row[4];
                $category_en->meta_title = $row[9];
                $category_en->meta_keywords = $row[10];
                $category_en->meta_description = $row[11];
                $category_en->save();
            }else{
                $category_en = new CategoryTranslation;
                $category_en->name = $row[2];
                $category_en->slug = $row[4];
                $category_en->category_id = $category_id;
                $category_en->locale = "en";
                $category_en->meta_title = $row[9];
                $category_en->meta_keywords = $row[10];
                $category_en->meta_description = $row[11];
                $category_en->save();
            }    
        }
        

    }
}
