<?php

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'doc' => $faker->cpf(false),
        'address_street' => $faker->streetName,
        'address_complement' => $faker->secondaryAddress,
        'address_neighborhood' => $faker->citySuffix,
        'address_city' => $faker->city,
        'address_state' => $faker->stateAbbr
    ];
});
