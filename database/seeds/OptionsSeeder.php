<?php

use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = [
            ['name'=>'select'],
            ['name'=>'radio'],
            ['name'=>'checkbox'],
            ['name'=>'text'],
            ['name'=>'textarea'],
            ['name'=>'file'],
            ['name'=>'date'],
            ['name'=>'time'],
            ['name'=>'date & time']
        ];

        $options = [
            ['field_id'=>'1', 'name'=>'color'],
            ['field_id'=>'4', 'name'=>'note']
        ];

        $optionsValues = [
            ['option_id'=>'1', 'value'=>'red'],
            ['option_id'=>'1', 'value'=>'green'],
        ];

        DB::table('fields')->insert($fields);
        DB::table('options')->insert($options);
        DB::table('options_values')->insert($optionsValues);
    }
}
