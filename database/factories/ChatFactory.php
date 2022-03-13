<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Chat;
use App\User;
use Faker\Generator as Faker;

$factory->define(Chat::class, function (Faker $faker) {
    $userCount = count(User::all());
    
    return [
        'message' => $faker->sentence(),
        'sender_id' => $faker->numberBetween(1, $userCount),
        'receiver_id' => $faker->numberBetween(1, $userCount),
    ];
});
