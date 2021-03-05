<?php

use Illuminate\Database\Seeder;

class BrandsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'name'  => 'ترايد لاين',
                'name_en'  => 'Trade line',
                'logo'  => 'https://tradelinestores.s3-accelerate.amazonaws.com/static/logo-n.png',
            ],
            [
                'name'  => 'هواوي',
                'name_en'  => 'HUAWEI',
                'logo'  => 'https://seeklogo.com/images/H/Huawei-logo-A8C7CBCAA8-seeklogo.com.png',
            ],
            [
                'name'  => 'سامسونج',
                'name_en'  => 'Samsung',
                'logo'  => 'https://www.medcityhq.com/wp-content/uploads/2017/06/samsung-logo-191-1.jpg',
            ],
            [
                'name'  => 'رايفن',
                'name_en'  => 'RaVin',
                'logo'  => 'https://plobalapps.s3.ap-southeast-1.amazonaws.com/rt-assets/images/1547210440183598296.jpg',
            ],
            [
                'name'  => 'انتل',
                'name_en'  => 'Intel',
                'logo'  => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Intel-logo.svg/1280px-Intel-logo.svg.png',
            ],
            [
                'name'  => 'تانك',
                'name_en'  => 'Tank',
                'logo'  => 'https://image.shutterstock.com/image-vector/tank-logo-template-military-concept-260nw-705450571.jpg',
            ],
        ];
        foreach ($brands as $b) {
            $brand = new \App\Brand();
            $brand->name = $b['name'];
            $brand->logo = $b['logo'];
            $brand->save();

            $categoryTrans = new \App\BrandTranslation();
            $categoryTrans->name = $b['name_en'];
            $categoryTrans->brand_id = $brand->id;
            $categoryTrans->locale = 'en';
            $categoryTrans->save();
        }
        # $users = factory(App\Brand::class, 30)->create();
    }
}
