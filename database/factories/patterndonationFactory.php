<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\PatternDonation;
use Faker\Generator as Faker;

$factory->define(PatternDonation::class, function (Faker $faker) {
    return [
            'name' => $faker->unique()->text(20),
            'description' => $faker->sentence
    ];
});
