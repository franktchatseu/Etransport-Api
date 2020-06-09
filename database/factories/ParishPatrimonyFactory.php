<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\ParishPatrimony;
use Faker\Generator as Faker;

$factory->define(ParishPatrimony::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence,
        'value' => $faker->numberBetween(0,1000),
    ];
});
