<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User_\Payment::class, function (Faker $faker) {
    $status = ['pending', 'success', 'failure'];

    return [
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'plan_id' => function() {
            return factory(App\Models\Plan::class)->create()->id;
        },
        'price' => rand(0, 100),
        'card_number' => $faker->creditCardNumber,
        'ccv' => rand(100, 999),
        'status' => $status[rand(0, 2)]
    ];
});
