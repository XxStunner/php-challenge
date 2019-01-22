<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User_\Phone::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'phone' => $faker->phone(false)
    ];
});
