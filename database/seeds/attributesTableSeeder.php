<?php

use Illuminate\Database\Seeder;

class attributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $attributes = [
            [
                'id' => '1',
                'group_id' => null,
            ],
            [
                'id' => '2',
                'group_id' => null,        	
            ],
            [
                'id' => '3',
                'group_id' => '1',        	
            ],
            [
                'id' => '4',
                'group_id' => '1',        	
            ],            
            [
                'id' => '5',
                'group_id' => '2',        	
            ],
            [
                'id' => '6',
                'group_id' => '2'        	
            ],
            [
                'id' => '7',
                'group_id' => '2'        	
            ],
            [
                'id' => '8',
                'group_id' => null,        	
            ],
            [
                'id' => '9',
                'group_id' => '8',        	
            ],
            [
                'id' => '10',
                'group_id' => '8',        	
            ]              
    
        ];

        $attribute_translations = [
            [
                'locale' => 'en',
                'name' => 'processor',
                'attribute_id' => '1'
            ],
            [
                'locale' => 'en',
                'name' => 'color',
                'attribute_id' => '2'        	
            ],
            [
                'locale' => 'en',
                'name' => 'octa cores',
                'attribute_id' => '3'        	
            ],
            [
                'locale' => 'en',
                'name' => '4 cores',
                'attribute_id' => '4'
            ],            
            [
                'locale' => 'en',
                'name' => 'red',
                'attribute_id' => '5'        	
            ],
            [
                'locale' => 'en',
                'name' => 'green',
                'attribute_id' => '6'        	
            ],
            [
                'locale' => 'en',
                'name' => 'blue',
                'attribute_id' => '7'        	
            ],
            [
                'locale' => 'en',
                'name' => 'shape',
                'attribute_id' => '8'        	
            ],
            [
                'locale' => 'en',
                'name' => 'sharp',
                'attribute_id' => '9'       	
            ],
            [
                'locale' => 'en',
                'name' => 'rounded',
                'attribute_id' => '10'        	
            ],    
            [
                'locale' => 'ar',
                'name' => 'معالج',
                'attribute_id' => '1'
            ],
            [
                'locale' => 'ar',
                'name' => 'اللون',
                'attribute_id' => '2'        	
            ],
            [
                'locale' => 'ar',
                'name' => 'ثماني النواة',
                'attribute_id' => '3'        	
            ],
            [
                'locale' => 'ar',
                'name' => 'رباعي النواة',
                'attribute_id' => '4'
            ],            
            [
                'locale' => 'ar',
                'name' => 'احمر',
                'attribute_id' => '5'        	
            ],
            [
                'locale' => 'ar',
                'name' => 'اخضر',
                'attribute_id' => '6'        	
            ],
            [
                'locale' => 'ar',
                'name' => 'ازرق',
                'attribute_id' => '7'        	
            ],
            [
                'locale' => 'ar',
                'name' => 'الشكل',
                'attribute_id' => '8'        	
            ],
            [
                'locale' => 'ar',
                'name' => 'حاد',
                'attribute_id' => '9'       	
            ],
            [
                'locale' => 'ar',
                'name' => 'دائري',
                'attribute_id' => '10'        	
            ]             
    
        ];
        
        $attributesIds = [3,4,5,6,7,9,10];
        for($i = 1 ; $i <= 500; $i++) {
            \DB::table('attribute_product')->insert([
                'attribute_id' => $attributesIds[array_rand($attributesIds)],
                'product_id' => rand(1,40),
                'quantity' => rand(100,1000)
            ]);
        }
        
        DB::table('attributes')->insert($attributes);
        DB::table('attribute_translations')->insert($attribute_translations);
 
    }
}
