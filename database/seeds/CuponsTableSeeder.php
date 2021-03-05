<?php

use Illuminate\Database\Seeder;

class CuponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('cupons')->insert(

        	[
        		'name' => 'happy eid',
        		'code' => 'happyeid100',
        		'type' => 'P',
        		'amount' => '25',
        		'start' => '2019-01-10',
        		'end' => '2019-01-11',
        		'usage_times' => '100',
				'user_usage_times' => '5',
				'min_order' => '1000'
        	]

        );    

        DB::table('cupons')->insert(

        	[
        		'name' => 'happy moms day',
        		'code' => 'happymom',
        		'type' => 'P',
        		'amount' => '30',
        		'start' => '2019-01-11',
        		'end' => '2019-01-12',
        		'usage_times' => '1000',
				'user_usage_times' => '100',
				'min_order' => '10000'
        	]

        );   

        DB::table('cupons')->insert(

        
        	[
        		'name' => 'new year',
        		'code' => 'newyear',
        		'type' => 'F',
        		'amount' => '100',
        		'start' => '2020-01-01',
        		'end' => '2020-01-02',
        		'usage_times' => '56',
				'user_usage_times' => '2',
				'min_order' => '5000'
        	]

        );   
        

    }
}
