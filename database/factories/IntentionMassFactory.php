<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\IntentionMass;
use Faker\Generator as Faker;

$factory->define(IntentionMass::class, function (Faker $faker) {
    return [
        'content' => $faker->text(),
        'amount' => $faker->numberBetween(10, 100000),
        'date' => $faker->date(),
        'intention' => $faker->text(),
        'status' => $faker->randomElement(['REJECTED','PENDING','ACCEPTED']),
    ];
});
