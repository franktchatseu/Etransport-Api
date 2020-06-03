<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Archiving;
use Faker\Generator as Faker;

$factory->define(Archiving::class, function (Faker $faker) {
    return [
        'motif' => $faker->sentence,
        'description' => $faker->sentence,
        'files' => json_encode(['https://picsum.photos/200/300']),
    ];
});
