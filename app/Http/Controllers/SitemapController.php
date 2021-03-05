<?php

namespace App\Http\Controllers;

use App\Category;
use App\Manufacturer;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
   public function sitemap(Request $request) {

       $sitemap = Sitemap::create()
           ->add(Url::create('/')
               ->setLastModificationDate(Carbon::yesterday())
               ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
               ->setPriority(0.1))
       ;

       # Products [en, ar]

       $products = Product::whereIsActive(true)->get();
       app()->setLocale('en');
       foreach ($products as $product) {
           $sitemap->add(Url::create('')
               ->setUrl($product->url_lang)
               ->setPriority(0.9));
       }

       app()->setLocale('ar');
       foreach ($products as $product) {
           $sitemap->add(Url::create('')
               ->setUrl($product->url_lang)
               ->setPriority(0.9));
       }

       $categories = Category::get();
       app()->setLocale('en');
       foreach ($categories as $product) {
           $sitemap->add(Url::create('')
               ->setUrl($product->url)
               ->setPriority(0.9));
       }
       app()->setLocale('ar');
       foreach ($categories as $product) {
           $sitemap->add(Url::create('')
               ->setUrl($product->url)
               ->setPriority(0.9));
       }

       return $sitemap->toResponse($request);

   }
}
