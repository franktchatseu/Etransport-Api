<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sacrament\Sacrament;
use Faker\Generator as Faker;

$factory->define(Sacrament::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(50),
        'description' => $faker->sentence,
    ];
});
