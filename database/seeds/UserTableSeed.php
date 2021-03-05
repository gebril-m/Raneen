<?php

use Illuminate\Database\Seeder;

class UserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                'name' => "admin",
                'email' => "admin@ranin.com",
                'password' => bcrypt('123456789'),
                'is_admin' => 1,
                'is_active' => 1,
            ]
        );
        DB::table('users')->insert([
                'name' => "admin",
                'email' => "admin@admin.com",
                'password' => bcrypt('123123'),
                'is_admin' => 0,
                'is_active' => 1,
            ]
        );
    }
}
