<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Brand;
use App\Country;
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

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name'          => $faker->country,
        'country_code'  => $faker->countryCode
    ];
});

$factory->define(\App\State::class, function (Faker $faker) {
    return [
        'name'          => $faker->state,
        'country_id'    => rand(1, 50),
    ];
});

$factory->define(\App\City::class, function (Faker $faker) {
    return [
        'name'          => $faker->city,
        'country_id'    => rand(1, 50),
        'state_id'    => rand(1, 50),
    ];
});
