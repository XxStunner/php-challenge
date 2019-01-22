<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Plan::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => rand(0, 100)
    ];
});
