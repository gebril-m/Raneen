<?php

use Illuminate\Database\Seeder;


class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\OrderStatus::insert([
            [
                'name' => 'New',
                'locale' => 'en',
            ],
            [
                'name' => 'Processing',
                'locale' => 'en',
            ],
            [
                'name' => 'Payment',
                'locale' => 'en',
            ],
            [
                'name' => 'Review',
                'locale' => 'en',
            ],
            [
                'name' => 'Complete',
                'locale' => 'en',
            ],
            [
                'name' => 'Cancelled',
                'locale' => 'en',
            ],
            [
                'name' => 'Decline',
                'locale' => 'en',
            ],
        ]);
    }


}
