<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use App\Category;
use App\Module;
use App\Page;
use App\Wishlist;
use Auth;
use Session;
use App\DealSection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (Category::whereIsActive(true)->whereParentId(0)->count() > 0) {
            $categories = Category::whereIsActive(true)->whereParentId(0)->orderBy('arrange','asc')->get();
            $categoryHeader = Category::whereIsActive(true)->whereInHeader(1)->orderBy('arrange','asc')->get();
        }else{
            $categories = null;
            $categoryHeader = null;
        }


        $pageHeader = Page::whereIsActive(1)->whereShowHeader(1)->get();



        $productsHasSale = \App\Product::where('is_hot','=',1)->where('is_active', '=',1)->where('stock', '>', 0)->where('hot_ends_at', '>', now())->orderBy('id','DESC')->limit(5)->get();




        $pagefooter = Page::whereIsActive(1)->whereShowFooter(1)->get();
        $now = date('Y-m-d');
        $dealsectionHeader = DealSection::where('is_active','=',1)->where('end_date','>',$now)->get();

        $discount_priroty=[
            'combo_order_id'=>\App\Periorty::where('name','combo')->first()->order_id,
            'on_sale_order_id'=>\App\Periorty::where('name','on_sale')->first()->order_id,
            'hot_order_id'=>\App\Periorty::where('name','hot')->first()->order_id,
            'promotion_order_id'=>\App\Periorty::where('name','promotion')->first()->order_id,
            'bundle_order_id'=>\App\Periorty::where('name','bundle')->first()->order_id,
            'coupon_order_id'=>\App\Periorty::where('name','coupon')->first()->order_id
        ];

        view()->share('categories', $categories);
        view()->share('category_header', $categoryHeader);
        view()->share('discount_priroty', $discount_priroty);

        view()->share('dealsection_header', $dealsectionHeader);
        view()->share('page_header', $pageHeader);
        view()->share('productsHasSale', $productsHasSale);

        view()->share('page_footer', $pagefooter);





        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
