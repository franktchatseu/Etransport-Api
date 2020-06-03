<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\Album;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence,
    ];
});
