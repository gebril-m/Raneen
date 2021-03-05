<?php

use Illuminate\Database\Seeder;

class ManufacturersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\Manufacturer::class, 70)->create();
    }
}
