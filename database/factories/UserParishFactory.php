<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\UserParish;
use Faker\Generator as Faker;

$factory->define(UserParish::class, function (Faker $faker) {
    return [
        'is_active' => $faker->boolean(),

    ];
});
