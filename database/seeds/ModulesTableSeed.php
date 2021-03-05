<?php

use Illuminate\Database\Seeder;

class ModulesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module = new \App\Module();
        $module->place = 'home_slider';
        $module->content = '{"place":"home_slider","order_id":"1","left_top_image":"vfpidzkw9wnxktip.jpg","left_top_product":"3","left_bottom_image":"6qwxhz0fnd8s9rlk.jpg","left_bottom_product":"4","slide":{"1":{"first_title":{"ar":"tx","en":"test"},"image":"ecdmq48kxlzi9glv.jpg","product":"3"}}}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_top_categories';
        $module->content = '{"place":"home_top_categories","first_category":"1","first_brand":"1","first_image":"https:\/\/via.placeholder.com\/540x244","second_category":"1","second_brand":"4","second_image":"https:\/\/via.placeholder.com\/540x244","third_category":"4","third_brand":"4","third_image":"https:\/\/via.placeholder.com\/540x244"}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_discount_banner';
        $module->content = '{}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_categories_products';
        $module->content = '{"place":"home_categories_products","categories":{"1":{"category":"3","type":"on_sales","limit":"5"},"2":{"category":"2","type":"latest","limit":"4"},"3":{"category":"5","type":"latest","limit":"2"},"4":{"category":"1","type":"latest","limit":"5"}}}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_product_banner';
        $module->content = '{"place":"home_product_banner","worda_ar":"Save Up To 30% Off","wordb_ar":"Women fashion","worda_en":"Save Up To 30% Off","wordb_en":"Women fashion","image":"https://via.placeholder.com/1656x302","link":null}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_deal_banner';
        $module->content = '{}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_hot_deals';
        $module->content = '{"place":"home_hot_deals","order_id":"2"}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_two_cards';
        $module->content = '{"place":"home_two_cards","order_id":"1","type_left":"product","product_left":"1","category_left":"1","image_left":"0ph8ouahkxb3qlws.jpg","type_right":"category","product_right":"1","category_right":"5","image_right":null}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_category_blocks';
        $module->content = '{"place":"home_two_cards"}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_hot_flash';
        $module->content = '{"place":"home_hot_flash","order_id":"2","product":"4","image":"0u2la6ov1rkkd0de.jpg"}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_circle_categories';
        $module->content = '{"place":"home_circle_categories","categories":{"1":{"category":"2","image":"https://via.placeholder.com/108"},"2":{"category":"1","image":"https://via.placeholder.com/108"},"3":{"category":"4","image":"https://via.placeholder.com/108"},"4":{"category":"6","image":"https://via.placeholder.com/108"}}}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_features';
        $module->content = '{}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_bottom_featured';
        $module->content = '{"place":"home_bottom_featured","new_active":"on","new_limit":"22","feature_limit":"12","best_limit":"12","sale_active":"on","sale_limit":"44"}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_bottom_categories';
        $module->content = '{"place":"home_top_categories","first_category":"1","first_brand":"1","first_image":"https:\/\/via.placeholder.com\/540x244","second_category":"1","second_brand":"4","second_image":"https:\/\/via.placeholder.com\/540x244","third_category":"4","third_brand":"4","third_image":"https:\/\/via.placeholder.com\/540x244"}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_special_products';
        $module->content = '{"place":"home_special_products","products":["2","7","7","11"]}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_related_products';
        $module->content = '{"place":"home_related_products","limit": 10}';
        $module->save();

        $module = $module->replicate();
        $module->place = 'home_question_banner';
        $module->content = '{}';
        $module->save();

    }
}
