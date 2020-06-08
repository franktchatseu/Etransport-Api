<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\AnnualmemberAuthorization;
use Faker\Generator as Faker;

$factory->define(AnnualmemberAuthorization::class, function (Faker $faker) {
    return [
        'date' => $faker->date(),
        'status' => $faker->randomElement(['PENDING', 'REJECTED', 'ACCEPTED']),
    ];
});
