<?php

use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_images')->delete();
        
        \DB::table('product_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'product_id' => 1,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/05/02/85/36/57/8/item_XL_8536578_31279073.jpg',
                'created_at' => '2019-11-10 15:40:14',
                'updated_at' => '2019-11-10 15:40:14',
            ),
            1 => 
            array (
                'id' => 2,
                'product_id' => 1,
                'image' => 'https://cf5.s3.souqcdn.com/item/2017/05/02/85/36/57/8/item_XL_8536578_31279074.jpg',
                'created_at' => '2019-11-10 15:40:14',
                'updated_at' => '2019-11-10 15:40:14',
            ),
            2 => 
            array (
                'id' => 3,
                'product_id' => 1,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/05/02/85/36/57/8/item_XL_8536578_31279075.jpg',
                'created_at' => '2019-11-10 15:40:14',
                'updated_at' => '2019-11-10 15:40:14',
            ),
            3 => 
            array (
                'id' => 4,
                'product_id' => 1,
                'image' => 'https://cf1.s3.souqcdn.com/item/2017/05/02/85/36/57/8/item_XL_8536578_31279077.jpg',
                'created_at' => '2019-11-10 15:40:14',
                'updated_at' => '2019-11-10 15:40:14',
            ),
            4 => 
            array (
                'id' => 5,
                'product_id' => 1,
                'image' => 'https://cf5.s3.souqcdn.com/item/2017/05/02/85/36/57/8/item_XL_8536578_31279078.jpg',
                'created_at' => '2019-11-10 15:40:14',
                'updated_at' => '2019-11-10 15:40:14',
            ),
            5 => 
            array (
                'id' => 6,
                'product_id' => 1,
                'image' => 'https://cf4.s3.souqcdn.com/item/2017/05/02/85/36/57/8/item_XL_8536578_31279079.jpg',
                'created_at' => '2019-11-10 15:40:14',
                'updated_at' => '2019-11-10 15:40:14',
            ),
            6 => 
            array (
                'id' => 7,
                'product_id' => 1,
                'image' => 'https://cf2.s3.souqcdn.com/item/2017/05/02/85/36/57/8/item_XL_8536578_31279080.jpg',
                'created_at' => '2019-11-10 15:40:14',
                'updated_at' => '2019-11-10 15:40:14',
            ),
            7 => 
            array (
                'id' => 8,
                'product_id' => 2,
                'image' => 'https://cf5.s3.souqcdn.com/item/2016/05/08/10/70/00/83/item_XL_10700083_14220480.jpg',
                'created_at' => '2019-11-10 15:40:16',
                'updated_at' => '2019-11-10 15:40:16',
            ),
            8 => 
            array (
                'id' => 9,
                'product_id' => 3,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/10/26/75/86/60/7/item_XL_7586607_56749309.jpg',
                'created_at' => '2019-11-10 15:40:18',
                'updated_at' => '2019-11-10 15:40:18',
            ),
            9 => 
            array (
                'id' => 10,
                'product_id' => 3,
                'image' => 'https://cf4.s3.souqcdn.com/item/2017/10/26/75/86/60/7/item_XL_7586607_56749310.jpg',
                'created_at' => '2019-11-10 15:40:18',
                'updated_at' => '2019-11-10 15:40:18',
            ),
            10 => 
            array (
                'id' => 11,
                'product_id' => 3,
                'image' => 'https://cf1.s3.souqcdn.com/item/2017/10/26/75/86/60/7/item_XL_7586607_56749311.jpg',
                'created_at' => '2019-11-10 15:40:18',
                'updated_at' => '2019-11-10 15:40:18',
            ),
            11 => 
            array (
                'id' => 12,
                'product_id' => 3,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/10/26/75/86/60/7/item_XL_7586607_56749312.jpg',
                'created_at' => '2019-11-10 15:40:18',
                'updated_at' => '2019-11-10 15:40:18',
            ),
            12 => 
            array (
                'id' => 13,
                'product_id' => 3,
                'image' => 'https://cf5.s3.souqcdn.com/item/2017/10/26/75/86/60/7/item_XL_7586607_56749313.jpg',
                'created_at' => '2019-11-10 15:40:18',
                'updated_at' => '2019-11-10 15:40:18',
            ),
            13 => 
            array (
                'id' => 14,
                'product_id' => 3,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/10/26/75/86/60/7/item_XL_7586607_56749314.jpg',
                'created_at' => '2019-11-10 15:40:18',
                'updated_at' => '2019-11-10 15:40:18',
            ),
            14 => 
            array (
                'id' => 15,
                'product_id' => 3,
                'image' => 'https://cf2.s3.souqcdn.com/item/2017/10/26/75/86/60/7/item_XL_7586607_56749315.jpg',
                'created_at' => '2019-11-10 15:40:18',
                'updated_at' => '2019-11-10 15:40:18',
            ),
            15 => 
            array (
                'id' => 16,
                'product_id' => 5,
                'image' => 'https://cf4.s3.souqcdn.com/item/2015/11/19/95/68/16/7/item_XL_9568167_10883856.jpg',
                'created_at' => '2019-11-10 15:40:24',
                'updated_at' => '2019-11-10 15:40:24',
            ),
            16 => 
            array (
                'id' => 17,
                'product_id' => 5,
                'image' => 'https://cf4.s3.souqcdn.com/item/2015/11/19/95/68/16/7/item_XL_9568167_10883857.jpg',
                'created_at' => '2019-11-10 15:40:24',
                'updated_at' => '2019-11-10 15:40:24',
            ),
            17 => 
            array (
                'id' => 18,
                'product_id' => 5,
                'image' => 'https://cf4.s3.souqcdn.com/item/2015/11/19/95/68/16/7/item_XL_9568167_10883859.jpg',
                'created_at' => '2019-11-10 15:40:24',
                'updated_at' => '2019-11-10 15:40:24',
            ),
            18 => 
            array (
                'id' => 19,
                'product_id' => 6,
                'image' => 'https://cf2.s3.souqcdn.com/item/2018/01/24/30/30/57/30/item_XL_30305730_94164650.jpg',
                'created_at' => '2019-11-10 15:40:27',
                'updated_at' => '2019-11-10 15:40:27',
            ),
            19 => 
            array (
                'id' => 20,
                'product_id' => 6,
                'image' => 'https://cf3.s3.souqcdn.com/item/2018/01/24/30/30/57/30/item_XL_30305730_94164679.jpg',
                'created_at' => '2019-11-10 15:40:27',
                'updated_at' => '2019-11-10 15:40:27',
            ),
            20 => 
            array (
                'id' => 21,
                'product_id' => 6,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/01/24/30/30/57/30/item_XL_30305730_94164694.jpg',
                'created_at' => '2019-11-10 15:40:27',
                'updated_at' => '2019-11-10 15:40:27',
            ),
            21 => 
            array (
                'id' => 22,
                'product_id' => 8,
                'image' => 'https://cf5.s3.souqcdn.com/item/2017/09/05/23/92/01/63/item_XL_23920163_34930873.jpg',
                'created_at' => '2019-11-10 15:40:33',
                'updated_at' => '2019-11-10 15:40:33',
            ),
            22 => 
            array (
                'id' => 23,
                'product_id' => 9,
                'image' => 'https://cf5.s3.souqcdn.com/item/2016/03/08/10/15/98/69/item_XL_10159869_12832160.jpg',
                'created_at' => '2019-11-10 15:40:35',
                'updated_at' => '2019-11-10 15:40:35',
            ),
            23 => 
            array (
                'id' => 24,
                'product_id' => 9,
                'image' => 'https://cf1.s3.souqcdn.com/item/2016/03/08/10/15/98/69/item_XL_10159869_12832162.jpg',
                'created_at' => '2019-11-10 15:40:35',
                'updated_at' => '2019-11-10 15:40:35',
            ),
            24 => 
            array (
                'id' => 25,
                'product_id' => 9,
                'image' => 'https://cf4.s3.souqcdn.com/item/2016/03/08/10/15/98/69/item_XL_10159869_12832165.jpg',
                'created_at' => '2019-11-10 15:40:35',
                'updated_at' => '2019-11-10 15:40:35',
            ),
            25 => 
            array (
                'id' => 26,
                'product_id' => 10,
                'image' => 'https://cf5.s3.souqcdn.com/item/2015/06/24/85/32/02/2/item_XL_8532022_8380988.jpg',
                'created_at' => '2019-11-10 15:40:38',
                'updated_at' => '2019-11-10 15:40:38',
            ),
            26 => 
            array (
                'id' => 27,
                'product_id' => 11,
                'image' => 'https://cf3.s3.souqcdn.com/item/2015/10/30/94/08/15/4/item_XL_9408154_10398843.jpg',
                'created_at' => '2019-11-10 15:40:41',
                'updated_at' => '2019-11-10 15:40:41',
            ),
            27 => 
            array (
                'id' => 28,
                'product_id' => 11,
                'image' => 'https://cf5.s3.souqcdn.com/item/2015/10/30/94/08/15/4/item_XL_9408154_10398844.jpg',
                'created_at' => '2019-11-10 15:40:41',
                'updated_at' => '2019-11-10 15:40:41',
            ),
            28 => 
            array (
                'id' => 29,
                'product_id' => 11,
                'image' => 'https://cf3.s3.souqcdn.com/item/2015/10/30/94/08/15/4/item_XL_9408154_10398846.jpg',
                'created_at' => '2019-11-10 15:40:41',
                'updated_at' => '2019-11-10 15:40:41',
            ),
            29 => 
            array (
                'id' => 30,
                'product_id' => 11,
                'image' => 'https://cf2.s3.souqcdn.com/item/2015/10/30/94/08/15/4/item_XL_9408154_10398847.jpg',
                'created_at' => '2019-11-10 15:40:41',
                'updated_at' => '2019-11-10 15:40:41',
            ),
            30 => 
            array (
                'id' => 31,
                'product_id' => 11,
                'image' => 'https://cf5.s3.souqcdn.com/item/2015/10/30/94/08/15/4/item_XL_9408154_10398848.jpg',
                'created_at' => '2019-11-10 15:40:41',
                'updated_at' => '2019-11-10 15:40:41',
            ),
            31 => 
            array (
                'id' => 32,
                'product_id' => 11,
                'image' => 'https://cf5.s3.souqcdn.com/item/2015/10/30/94/08/15/4/item_XL_9408154_10398849.jpg',
                'created_at' => '2019-11-10 15:40:41',
                'updated_at' => '2019-11-10 15:40:41',
            ),
            32 => 
            array (
                'id' => 33,
                'product_id' => 11,
                'image' => 'https://cf2.s3.souqcdn.com/item/2015/10/30/94/08/15/4/item_XL_9408154_10398850.jpg',
                'created_at' => '2019-11-10 15:40:41',
                'updated_at' => '2019-11-10 15:40:41',
            ),
            33 => 
            array (
                'id' => 34,
                'product_id' => 13,
                'image' => 'https://cf5.s3.souqcdn.com/item/2017/10/01/99/52/70/2/item_XL_9952702_35908678.jpg',
                'created_at' => '2019-11-10 15:40:46',
                'updated_at' => '2019-11-10 15:40:46',
            ),
            34 => 
            array (
                'id' => 35,
                'product_id' => 13,
                'image' => 'https://cf4.s3.souqcdn.com/item/2017/10/01/99/52/70/2/item_XL_9952702_35908682.jpg',
                'created_at' => '2019-11-10 15:40:46',
                'updated_at' => '2019-11-10 15:40:46',
            ),
            35 => 
            array (
                'id' => 36,
                'product_id' => 13,
                'image' => 'https://cf5.s3.souqcdn.com/item/2017/10/01/99/52/70/2/item_XL_9952702_35908687.jpg',
                'created_at' => '2019-11-10 15:40:46',
                'updated_at' => '2019-11-10 15:40:46',
            ),
            36 => 
            array (
                'id' => 37,
                'product_id' => 13,
                'image' => 'https://cf2.s3.souqcdn.com/item/2017/10/01/99/52/70/2/item_XL_9952702_35908698.jpg',
                'created_at' => '2019-11-10 15:40:46',
                'updated_at' => '2019-11-10 15:40:46',
            ),
            37 => 
            array (
                'id' => 38,
                'product_id' => 14,
                'image' => 'https://cf3.s3.souqcdn.com/item/2019/05/21/27/45/40/88/item_XL_27454088_2d37f6f4fb8c5.jpg',
                'created_at' => '2019-11-10 15:40:49',
                'updated_at' => '2019-11-10 15:40:49',
            ),
            38 => 
            array (
                'id' => 39,
                'product_id' => 14,
                'image' => 'https://cf4.s3.souqcdn.com/item/2019/05/21/27/45/40/88/item_XL_27454088_b878343fbf484.jpg',
                'created_at' => '2019-11-10 15:40:49',
                'updated_at' => '2019-11-10 15:40:49',
            ),
            39 => 
            array (
                'id' => 40,
                'product_id' => 14,
                'image' => 'https://cf1.s3.souqcdn.com/item/2019/05/21/27/45/40/88/item_XL_27454088_3b3f43e6390c3.jpg',
                'created_at' => '2019-11-10 15:40:49',
                'updated_at' => '2019-11-10 15:40:49',
            ),
            40 => 
            array (
                'id' => 41,
                'product_id' => 14,
                'image' => 'https://cf3.s3.souqcdn.com/item/2019/05/21/27/45/40/88/item_XL_27454088_fab24c127c069.jpg',
                'created_at' => '2019-11-10 15:40:49',
                'updated_at' => '2019-11-10 15:40:49',
            ),
            41 => 
            array (
                'id' => 42,
                'product_id' => 14,
                'image' => 'https://cf4.s3.souqcdn.com/item/2019/05/21/27/45/40/88/item_XL_27454088_f3446606ca6e9.jpg',
                'created_at' => '2019-11-10 15:40:49',
                'updated_at' => '2019-11-10 15:40:49',
            ),
            42 => 
            array (
                'id' => 43,
                'product_id' => 16,
                'image' => 'https://cf5.s3.souqcdn.com/item/2014/09/25/73/30/25/1/item_XL_7330251_5701244.jpg',
                'created_at' => '2019-11-10 15:40:55',
                'updated_at' => '2019-11-10 15:40:55',
            ),
            43 => 
            array (
                'id' => 44,
                'product_id' => 16,
                'image' => 'https://cf2.s3.souqcdn.com/item/2014/09/25/73/30/25/1/item_XL_7330251_5701246.jpg',
                'created_at' => '2019-11-10 15:40:55',
                'updated_at' => '2019-11-10 15:40:55',
            ),
            44 => 
            array (
                'id' => 45,
                'product_id' => 20,
                'image' => 'https://cf2.s3.souqcdn.com/item/2015/02/15/78/57/45/3/item_XL_7857453_6919286.jpg',
                'created_at' => '2019-11-10 15:41:06',
                'updated_at' => '2019-11-10 15:41:06',
            ),
            45 => 
            array (
                'id' => 46,
                'product_id' => 21,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/14/30/67/91/11/item_XL_30679111_110754187.jpg',
                'created_at' => '2019-11-10 15:41:09',
                'updated_at' => '2019-11-10 15:41:09',
            ),
            46 => 
            array (
                'id' => 47,
                'product_id' => 21,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/14/30/67/91/11/item_XL_30679111_110754221.jpg',
                'created_at' => '2019-11-10 15:41:09',
                'updated_at' => '2019-11-10 15:41:09',
            ),
            47 => 
            array (
                'id' => 48,
                'product_id' => 21,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/14/30/67/91/11/item_XL_30679111_110754250.jpg',
                'created_at' => '2019-11-10 15:41:09',
                'updated_at' => '2019-11-10 15:41:09',
            ),
            48 => 
            array (
                'id' => 49,
                'product_id' => 22,
                'image' => 'https://cf3.s3.souqcdn.com/item/2019/03/10/23/86/59/09/item_XL_23865909_085df458b7822.jpg',
                'created_at' => '2019-11-10 15:41:11',
                'updated_at' => '2019-11-10 15:41:11',
            ),
            49 => 
            array (
                'id' => 50,
                'product_id' => 22,
                'image' => 'https://cf4.s3.souqcdn.com/item/2019/03/10/23/86/59/09/item_XL_23865909_d85bd509299bb.jpg',
                'created_at' => '2019-11-10 15:41:11',
                'updated_at' => '2019-11-10 15:41:11',
            ),
            50 => 
            array (
                'id' => 51,
                'product_id' => 22,
                'image' => 'https://cf1.s3.souqcdn.com/item/2019/03/10/23/86/59/09/item_XL_23865909_b0b8c87923570.jpg',
                'created_at' => '2019-11-10 15:41:11',
                'updated_at' => '2019-11-10 15:41:11',
            ),
            51 => 
            array (
                'id' => 52,
                'product_id' => 22,
                'image' => 'https://cf2.s3.souqcdn.com/item/2019/03/10/23/86/59/09/item_XL_23865909_52a4daac9e615.jpg',
                'created_at' => '2019-11-10 15:41:11',
                'updated_at' => '2019-11-10 15:41:11',
            ),
            52 => 
            array (
                'id' => 53,
                'product_id' => 25,
                'image' => 'https://cf3.s3.souqcdn.com/item/2016/03/08/10/15/98/62/item_XL_10159862_12832102.jpg',
                'created_at' => '2019-11-10 15:41:19',
                'updated_at' => '2019-11-10 15:41:19',
            ),
            53 => 
            array (
                'id' => 54,
                'product_id' => 25,
                'image' => 'https://cf1.s3.souqcdn.com/item/2016/03/08/10/15/98/62/item_XL_10159862_12832105.jpg',
                'created_at' => '2019-11-10 15:41:19',
                'updated_at' => '2019-11-10 15:41:19',
            ),
            54 => 
            array (
                'id' => 55,
                'product_id' => 25,
                'image' => 'https://cf2.s3.souqcdn.com/item/2016/03/08/10/15/98/62/item_XL_10159862_12832111.jpg',
                'created_at' => '2019-11-10 15:41:19',
                'updated_at' => '2019-11-10 15:41:19',
            ),
            55 => 
            array (
                'id' => 56,
                'product_id' => 26,
                'image' => 'https://cf1.s3.souqcdn.com/item/2017/01/12/11/78/21/20/item_XL_11782120_18404018.jpg',
                'created_at' => '2019-11-10 15:41:21',
                'updated_at' => '2019-11-10 15:41:21',
            ),
            56 => 
            array (
                'id' => 57,
                'product_id' => 27,
                'image' => 'https://cf2.s3.souqcdn.com/item/2017/08/16/23/82/85/75/item_XL_23828575_34516049.jpg',
                'created_at' => '2019-11-10 15:41:24',
                'updated_at' => '2019-11-10 15:41:24',
            ),
            57 => 
            array (
                'id' => 58,
                'product_id' => 27,
                'image' => 'https://cf4.s3.souqcdn.com/item/2017/08/16/23/82/85/75/item_XL_23828575_34516051.jpg',
                'created_at' => '2019-11-10 15:41:24',
                'updated_at' => '2019-11-10 15:41:24',
            ),
            58 => 
            array (
                'id' => 59,
                'product_id' => 29,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/05/21/22/83/56/04/item_XL_22835604_31850878.jpg',
                'created_at' => '2019-11-10 15:41:28',
                'updated_at' => '2019-11-10 15:41:28',
            ),
            59 => 
            array (
                'id' => 60,
                'product_id' => 29,
                'image' => 'https://cf5.s3.souqcdn.com/item/2017/05/21/22/83/56/04/item_XL_22835604_31850887.jpg',
                'created_at' => '2019-11-10 15:41:28',
                'updated_at' => '2019-11-10 15:41:28',
            ),
            60 => 
            array (
                'id' => 61,
                'product_id' => 29,
                'image' => 'https://cf4.s3.souqcdn.com/item/2017/05/21/22/83/56/04/item_XL_22835604_31850906.jpg',
                'created_at' => '2019-11-10 15:41:28',
                'updated_at' => '2019-11-10 15:41:28',
            ),
            61 => 
            array (
                'id' => 62,
                'product_id' => 29,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/05/21/22/83/56/04/item_XL_22835604_31851006.jpg',
                'created_at' => '2019-11-10 15:41:28',
                'updated_at' => '2019-11-10 15:41:28',
            ),
            62 => 
            array (
                'id' => 63,
                'product_id' => 29,
                'image' => 'https://cf4.s3.souqcdn.com/item/2017/05/21/22/83/56/04/item_XL_22835604_31851009.jpg',
                'created_at' => '2019-11-10 15:41:29',
                'updated_at' => '2019-11-10 15:41:29',
            ),
            63 => 
            array (
                'id' => 64,
                'product_id' => 31,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/06/30/56/14/83/item_XL_30561483_108052699.jpg',
                'created_at' => '2019-11-10 15:41:34',
                'updated_at' => '2019-11-10 15:41:34',
            ),
            64 => 
            array (
                'id' => 65,
                'product_id' => 31,
                'image' => 'https://cf4.s3.souqcdn.com/item/2018/02/06/30/56/14/83/item_XL_30561483_108052701.jpg',
                'created_at' => '2019-11-10 15:41:34',
                'updated_at' => '2019-11-10 15:41:34',
            ),
            65 => 
            array (
                'id' => 66,
                'product_id' => 31,
                'image' => 'https://cf5.s3.souqcdn.com/item/2018/02/06/30/56/14/83/item_XL_30561483_108052704.jpg',
                'created_at' => '2019-11-10 15:41:34',
                'updated_at' => '2019-11-10 15:41:34',
            ),
            66 => 
            array (
                'id' => 67,
                'product_id' => 31,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/06/30/56/14/83/item_XL_30561483_108052705.jpg',
                'created_at' => '2019-11-10 15:41:34',
                'updated_at' => '2019-11-10 15:41:34',
            ),
            67 => 
            array (
                'id' => 68,
                'product_id' => 31,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/06/30/56/14/83/item_XL_30561483_108052706.jpg',
                'created_at' => '2019-11-10 15:41:34',
                'updated_at' => '2019-11-10 15:41:34',
            ),
            68 => 
            array (
                'id' => 69,
                'product_id' => 31,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/06/30/56/14/83/item_XL_30561483_108052709.jpg',
                'created_at' => '2019-11-10 15:41:34',
                'updated_at' => '2019-11-10 15:41:34',
            ),
            69 => 
            array (
                'id' => 70,
                'product_id' => 31,
                'image' => 'https://cf5.s3.souqcdn.com/item/2018/02/06/30/56/14/83/item_XL_30561483_108052711.jpg',
                'created_at' => '2019-11-10 15:41:34',
                'updated_at' => '2019-11-10 15:41:34',
            ),
            70 => 
            array (
                'id' => 71,
                'product_id' => 32,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/08/02/23/66/69/35/item_XL_23666935_34008099.jpg',
                'created_at' => '2019-11-10 15:41:36',
                'updated_at' => '2019-11-10 15:41:36',
            ),
            71 => 
            array (
                'id' => 72,
                'product_id' => 34,
                'image' => 'https://cf5.s3.souqcdn.com/item/2016/05/08/10/70/00/83/item_XL_10700083_14220480.jpg',
                'created_at' => '2019-11-10 15:41:41',
                'updated_at' => '2019-11-10 15:41:41',
            ),
            72 => 
            array (
                'id' => 73,
                'product_id' => 35,
                'image' => 'https://cf3.s3.souqcdn.com/item/2017/12/05/28/77/87/45/item_XL_28778745_80910350.jpg',
                'created_at' => '2019-11-10 15:41:43',
                'updated_at' => '2019-11-10 15:41:43',
            ),
            73 => 
            array (
                'id' => 74,
                'product_id' => 35,
                'image' => 'https://cf4.s3.souqcdn.com/item/2017/12/05/28/77/87/45/item_XL_28778745_80910351.jpg',
                'created_at' => '2019-11-10 15:41:43',
                'updated_at' => '2019-11-10 15:41:43',
            ),
            74 => 
            array (
                'id' => 75,
                'product_id' => 36,
                'image' => 'https://cf5.s3.souqcdn.com/item/2015/06/24/85/32/02/2/item_XL_8532022_8380988.jpg',
                'created_at' => '2019-11-10 15:41:45',
                'updated_at' => '2019-11-10 15:41:45',
            ),
            75 => 
            array (
                'id' => 76,
                'product_id' => 37,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/09/25/67/25/38/2/item_XL_6725382_151540265.jpg',
                'created_at' => '2019-11-10 15:41:48',
                'updated_at' => '2019-11-10 15:41:48',
            ),
            76 => 
            array (
                'id' => 77,
                'product_id' => 37,
                'image' => 'https://cf3.s3.souqcdn.com/item/2018/09/25/67/25/38/2/item_XL_6725382_151540267.jpg',
                'created_at' => '2019-11-10 15:41:48',
                'updated_at' => '2019-11-10 15:41:48',
            ),
            77 => 
            array (
                'id' => 78,
                'product_id' => 37,
                'image' => 'https://cf3.s3.souqcdn.com/item/2018/09/25/67/25/38/2/item_XL_6725382_151540270.jpg',
                'created_at' => '2019-11-10 15:41:48',
                'updated_at' => '2019-11-10 15:41:48',
            ),
            78 => 
            array (
                'id' => 79,
                'product_id' => 37,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/09/25/67/25/38/2/item_XL_6725382_151540275.jpg',
                'created_at' => '2019-11-10 15:41:48',
                'updated_at' => '2019-11-10 15:41:48',
            ),
            79 => 
            array (
                'id' => 80,
                'product_id' => 37,
                'image' => 'https://cf5.s3.souqcdn.com/item/2018/09/25/67/25/38/2/item_XL_6725382_151540278.jpg',
                'created_at' => '2019-11-10 15:41:48',
                'updated_at' => '2019-11-10 15:41:48',
            ),
            80 => 
            array (
                'id' => 81,
                'product_id' => 37,
                'image' => 'https://cf5.s3.souqcdn.com/item/2018/09/25/67/25/38/2/item_XL_6725382_151540506.jpg',
                'created_at' => '2019-11-10 15:41:48',
                'updated_at' => '2019-11-10 15:41:48',
            ),
            81 => 
            array (
                'id' => 82,
                'product_id' => 38,
                'image' => 'https://cf3.s3.souqcdn.com/item/2018/02/12/30/65/59/59/item_XL_30655959_110485915.jpg',
                'created_at' => '2019-11-10 15:41:50',
                'updated_at' => '2019-11-10 15:41:50',
            ),
            82 => 
            array (
                'id' => 83,
                'product_id' => 38,
                'image' => 'https://cf3.s3.souqcdn.com/item/2018/02/12/30/65/59/59/item_XL_30655959_110485921.jpg',
                'created_at' => '2019-11-10 15:41:50',
                'updated_at' => '2019-11-10 15:41:50',
            ),
            83 => 
            array (
                'id' => 84,
                'product_id' => 38,
                'image' => 'https://cf5.s3.souqcdn.com/item/2018/02/12/30/65/59/59/item_XL_30655959_110485931.jpg',
                'created_at' => '2019-11-10 15:41:50',
                'updated_at' => '2019-11-10 15:41:50',
            ),
            84 => 
            array (
                'id' => 85,
                'product_id' => 38,
                'image' => 'https://cf1.s3.souqcdn.com/item/2018/02/12/30/65/59/59/item_XL_30655959_110485939.jpg',
                'created_at' => '2019-11-10 15:41:50',
                'updated_at' => '2019-11-10 15:41:50',
            ),
            85 => 
            array (
                'id' => 86,
                'product_id' => 40,
                'image' => 'https://cf2.s3.souqcdn.com/item/2015/02/15/78/57/45/3/item_XL_7857453_6919286.jpg',
                'created_at' => '2019-11-10 15:41:56',
                'updated_at' => '2019-11-10 15:41:56',
            ),
            86 => 
            array (
                'id' => 87,
                'product_id' => 41,
                'image' => 'yrgqeus7ynqvawxz.jpeg',
                'created_at' => '2019-11-11 10:32:46',
                'updated_at' => '2019-11-11 10:32:46',
            ),
            87 => 
            array (
                'id' => 88,
                'product_id' => 42,
                'image' => 'ltztouvg8dlb2uer.jpg',
                'created_at' => '2019-11-11 10:38:43',
                'updated_at' => '2019-11-11 10:38:43',
            ),
            88 => 
            array (
                'id' => 89,
                'product_id' => 43,
                'image' => '1tg1sx6mmfuckblz.jpg',
                'created_at' => '2019-11-11 13:10:54',
                'updated_at' => '2019-11-11 13:10:54',
            ),
            89 => 
            array (
                'id' => 90,
                'product_id' => 44,
                'image' => 'g4jnq4wj0ip8amtt.jpg',
                'created_at' => '2019-11-11 13:30:19',
                'updated_at' => '2019-11-11 13:30:19',
            ),
            90 => 
            array (
                'id' => 92,
                'product_id' => 46,
                'image' => '4bxwvx72ircguefk.jpg',
                'created_at' => '2019-11-12 12:28:38',
                'updated_at' => '2019-11-12 12:28:38',
            ),
            91 => 
            array (
                'id' => 93,
                'product_id' => 45,
                'image' => '2uaoaupqr4cmrmq3.jpg',
                'created_at' => '2019-11-12 23:01:38',
                'updated_at' => '2019-11-12 23:01:38',
            ),
            92 => 
            array (
                'id' => 94,
                'product_id' => 47,
                'image' => 'hwwq837l59bdbrml.jpg',
                'created_at' => '2019-11-13 09:59:06',
                'updated_at' => '2019-11-13 09:59:06',
            ),
            93 => 
            array (
                'id' => 95,
                'product_id' => 48,
                'image' => 'jridawpdi2bfilyh.png',
                'created_at' => '2019-11-13 10:18:22',
                'updated_at' => '2019-11-13 10:18:22',
            ),
            94 => 
            array (
                'id' => 96,
                'product_id' => 49,
                'image' => 'mn7yrkgymgsfpp2e.jpg',
                'created_at' => '2019-11-13 10:20:27',
                'updated_at' => '2019-11-13 10:20:27',
            ),
            95 => 
            array (
                'id' => 97,
                'product_id' => 50,
                'image' => 'mxriioazwlzwi6cp.jpg',
                'created_at' => '2019-11-13 13:14:03',
                'updated_at' => '2019-11-13 13:14:03',
            ),
        ));
        
        
    }
}