<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'          => $faker->name,
        'slug'          => $faker->slug,
        'description'   => $faker->text,

        'brand_id' => rand(1, 30),
        'manufacturer_id' => rand(1, 70),
        'stock' => rand(1, 30),
        'minimum_stock' => rand(1, 7),
        'price' => rand(30, 9999),
        'is_active' => rand(0, 1),
        'up_selling' => rand(0, 1),
        'return_allowed' => rand(0, 1),
        'return_duration' => rand(1, 7),
    ];
});
