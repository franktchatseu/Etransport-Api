<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Planification\Planing;
use Faker\Generator as Faker;

$factory->define(Planing::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(),
        'date' => $faker->date(),
        'nature' => $faker->sentence(),
        'activity' => $faker->sentence(),
        'activityPro' => $faker->sentence(),
        'place' => $faker->sentence(),
    ];
});
