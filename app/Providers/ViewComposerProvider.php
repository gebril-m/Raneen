<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use App\Page ;
class ViewComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.component._header','layouts.component._sidbar','layouts.component._category','layouts.app','website.components.header'], function ($view) {
            $locale = App::getLocale();
            $categories = Category::whereIsActive(true)->whereParentId(0)->get();
            
            $allcategories = Category::whereIsActive(true)->get();
            $categoryHeader = Category::whereIsActive(true)->whereInHeader(1)->get();
            $pageHeader = Page::whereIsActive(1)->whereShowHeader(1)->get();
            $pagefooter = Page::whereIsActive(1)->whereShowFooter(1)->get();
            session()->forget('products.cart.null');
            $cart = session()->get('products.cart');
            $cart_counter = 0;
            if ($cart)
            foreach ($cart as $c){
                $cart_counter += $c[0]['quantity'] ? $c[0]['quantity'] : 1 ;
            }
            $view->with(['locale'=> $locale,'categories'=>$categories,'allcategories'=>$allcategories,'cart_counter'=>$cart_counter,
                'page_header'=>$pageHeader,'page_footer'=>$pagefooter ,'category_header'=>$categoryHeader]);
        });
    }
}
