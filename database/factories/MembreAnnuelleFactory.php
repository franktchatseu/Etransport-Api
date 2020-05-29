<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\MembreAnnuelle;
use Faker\Generator as Faker;

$factory->define(MembreAnnuelle::class, function (Faker $faker) {
    return [
        'class' => $faker->sentence,
        'is_admin' => $faker->boolean(),
    ];
});
