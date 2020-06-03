<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sacrament\SacramentCategorie;
use Faker\Generator as Faker;

$factory->define(SacramentCategorie::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(50),
        'description' => $faker->sentence,
    ];
});
