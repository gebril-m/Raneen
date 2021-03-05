<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $location = new \App\Location();
            $location->location = 'فرع الكرمة ( اسكنرية )';
            $location->city_id = 1;
            $location->save();
            $location = new \App\Location();
            $location->location = 'فرع دمنهور';
            $location->city_id = 2;
            $location->save();
            $location = new \App\Location();
            $location->location = 'فرع بني سويف';
            $location->city_id = 3;
            $location->save();
        }
}
