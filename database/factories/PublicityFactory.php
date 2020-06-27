<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Publicity\Publicity;
use Faker\Generator as Faker;

$factory->define(Publicity::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10),
        'description' => $faker->sentence(),
        'date_end' => $faker->date(),
        'photos' => $faker->sentence(),
    ];
});
