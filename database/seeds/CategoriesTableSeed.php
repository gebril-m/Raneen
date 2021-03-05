<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories_en = [
            'Electronics',
            'Laptop',
            'TVs',
            'Headphones & Speakers',
            'Cameras & Accessories',
            'Kindle',
        ];

        # Description
        # Icon
        # Banner
        #

        $categories_ar = [
            'إلكترونيات',
            'لابتوب',
            'تلفزيونات',
            'سماعات',
            'الكاميرات و ملحقاتها',
            'تابلت للقراءه',
        ];

        foreach ($categories_ar as $x => $cat) {
            $category = new \App\Category();
            $category->parent_id = $x == 0 ? 0 : 1;
            $category->name = $cat;
            $category->slug = str_slug($cat);
            $category->is_active = true;
            $category->in_header = false;
            $category->save();

            $categoryTrans = new \App\CategoryTranslation();
            $categoryTrans->name = $categories_en[$x];
            $categoryTrans->category_id = $category->id;
            $categoryTrans->slug = str_slug($categories_en[$x]);
            $categoryTrans->locale = 'en';
            $categoryTrans->save();
        }

    }
}
