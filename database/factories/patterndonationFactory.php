<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\PatternDonation;
use Faker\Generator as Faker;

$factory->define(PatternDonation::class, function (Faker $faker) {
    return [
            'name' => $faker->sentence,
            'description' => $faker->sentence
    ];
});
