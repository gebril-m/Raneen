<?php

use Illuminate\Database\Seeder;

class InventoriesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $inventory = new \App\Inventory();
        $inventory->name = 'New Cairo';
        $inventory->save();

        $inventory = new \App\Inventory();
        $inventory->name = 'Nasr City';
        $inventory->save();

    }
}
