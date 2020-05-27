<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Person\Sacrament;
use Faker\Generator as Faker;

$factory->define(Sacrament::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->sentence,
        'description' => $faker->paragraph(),
    ];
});
