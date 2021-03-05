<?php

use Illuminate\Database\Seeder;

class LangaugeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('translator_languages')->insert([
                'name' => "Arabic",
                'locale' => "ar",
            ]
        );
        DB::table('translator_languages')->insert(  [
                'name' => "English",
                'locale' => "en",
            ]
        );
    }
}
