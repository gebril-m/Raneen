<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function homeCircleCategories(){
        if (Module::whereIsActive(1)->where('place','home_circle_categories')->count() > 0) {
            $home_circle_categories = Module::whereIsActive(1)->where('place','home_circle_categories')->get()->first()->content;
            $homeCircleCategories = json_decode($home_circle_categories)->categories;
        }
        else{
            $homeCircleCategories = null;
        }
        return $homeCircleCategories;
    }
    public function homeCategories()
    {
        if ($home_categories_products = Module::whereIsActive(1)->where('place', 'home_categories_products')->get()->first()) {
            $home_categories_products = $home_categories_products->content;
            $homeCategories = json_decode($home_categories_products)->categories;
        } else {
            $homeCategories = null;
        }
        return $homeCategories;
    }
    public function bigSale(){
        $special = Module::whereIsActive(1)->where('place','home_special_products')->get()->first()->content;
        $specialProducts = json_decode($special);
        if (Module::whereIsActive(1)->where('place','home_product_banner')->count() > 0) {
            $home_product_banner = Module::whereIsActive(1)->where('place','home_product_banner')->get()->first()->content;
            $bigSale = json_decode($home_product_banner);
        }else{
            $bigSale = null;
        }
        return [$bigSale,$specialProducts];
    }
    public function slider(){
        if (Module::whereIsActive(1)->where('place','home_slider')->count() > 0) {
            $data = Module::whereIsActive(1)->where('place','home_slider')->get()->first()->content;
            $slider = json_decode($data)->slide;
        }
        else{
            $slider = null;
        }
        return $slider;
    }

    public function homeTwoCards(){
        if (Module::whereIsActive(1)->where('place','home_two_cards')->count() > 0) {
            $home_two_cards = Module::whereIsActive(1)->where('place','home_two_cards')->get()->first()->content;
            $homeTwoCards = json_decode($home_two_cards);
        }else{
            $homeTwoCards = null;
        }
        return $homeTwoCards;
    }


}
