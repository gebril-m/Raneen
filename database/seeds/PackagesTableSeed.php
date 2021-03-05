<?php

use Illuminate\Database\Seeder;


class PackagesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $package = new \App\Package();
        $package->name = 'package1';
        $package->price = '2200';
        $package->duration = 2;
        $package->description = 'good package ';
        $package->is_active = 1;
        $package->save();

        $package = new \App\Package();
        $package->name = 'package2';
        $package->price = '5000';
        $package->duration = 1;
        $package->description = 'good package ';
        $package->is_active = 1;
        $package->save();

        $package = new \App\Package();
        $package->name = 'package3';
        $package->price = '6000';
        $package->duration = 3;
        $package->description = 'good package ';
        $package->is_active = 0;
        $package->save();

        $package = new \App\Package();
        $package->name = 'package4';
        $package->price = '8800';
        $package->duration = 5;
        $package->description = 'good package ';
        $package->is_active = 0;
        $package->save();
    }

       
}
