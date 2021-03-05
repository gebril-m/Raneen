<?php

use App\ProductImage;
use Illuminate\Database\Seeder;

require_once 'souq.php';

class ProductsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $souq = true;
        $num = 500;

        if($souq) {
            $num = 500;
            $products = get_products('https://deals.souq.com/eg-ar/%D9%85%D9%88%D8%A8%D8%A7%D9%8A%D9%84%D8%A7%D8%AA-%D9%88%D8%A7%D9%83%D8%B3%D8%B3%D9%88%D8%A7%D8%B1%D8%A7%D8%AA/c/14731');
            $products = array_merge($products, get_products('https://egypt.souq.com/eg-ar/hp/laptops---and---notebooks-75/a-t/s/?fbs=yes&sortby=sr&'));

            echo "FOUND " . sizeof($products) . "s products" . PHP_EOL;

            foreach ($products as $link) {
                $link = $link['link'];
                # if ($x == 1) break;

                echo "FETCHING " . $link . PHP_EOL;

                $en = get_product($link, 'en');
                $pro = get_product($link);

                $product = new \App\Product();
                $product->name              = mb_substr($pro['title'], 0, 190);
                $product->slug              = trim(mb_substr(str_replace(' ',"-",$pro['title']), 0, 190));
                $product->description       = $pro['description'];
                $product->brand_id          = rand(1, 5);
                $product->manufacturer_id   = rand(1, 5);
                $product->stock             = rand(1, 30);
                $product->minimum_stock     = rand(1, 7);
                // $product->price             = $p['price'];
                $product->before_price             = rand(10000, 999999);
                $product->hot_price             = rand(10000, 999999);
                $product->price             = rand(1, 10000);
                $product->is_active         = true;
                $product->up_selling        = rand(0, 1);
                $on_sale                     = rand(0, 1);
                $is_hot                     = rand(0, 1);
                $product->on_sale = $on_sale;
                $product->is_hot = $is_hot;
                if ($is_hot) {
                    $product->hot_starts_at = now()->addDays(rand(1, 99));
                    $product->hot_ends_at = now()->addDays(rand(1, 99));
                }
                $product->return_allowed    = rand(0, 1);
                $product->return_duration   = rand(1, 7);
                $product->thumbnail         = $pro['thumbnail'];
                $product->save();

                $pt = new \App\ProductTranslation();
                $pt->product_id = $product->id;
                $pt->name = mb_substr($en['title'], 0, 190);
                $pt->slug  = trim(str_replace(' ',"-",mb_substr($pt->name, 0, 190)));
                $pt->locale = 'en';
                $pt->description = $en['description'];
                $pt->save();

                foreach ($pro['images'] as $img) {
                    $productImg = new ProductImage();
                    $productImg->image = $img;
                    $productImg->product_id = $product->id;
                    $productImg->save();
                }
            }
        } else {
            factory(App\Product::class, 500)->create()->each(function ($product) {

                $faker = \Faker\Factory::create();

                $productTrans = new \App\ProductTranslation();
                $productTrans->name = $faker->name;
                $productTrans->slug = $faker->slug;
                $productTrans->description = $faker->text;
                $productTrans->locale = 'en';
                $productTrans->product_id = $product->id;
                $productTrans->save();

                # $product->images()->save(factory(App\ProductImage::class, 2)->make());
            });
        }


       for($i = 1 ; $i <= $num; $i++) {
           \DB::table('product_categories')->insert([
               'category_id' => rand(1, 6),
               'product_id' => $i,
           ]);
       }

    }
}
