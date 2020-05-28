<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\Nature;
use Faker\Generator as Faker;

$factory->define(Nature::class, function (Faker $faker) {
    return [
        'name' =>  $faker->text(20),
        'description' => $faker->text(100),
        'status' => $faker->randomElement(['ELEVE', 'ETUDIANT', 'HOMME', 'FEMME']),
        'amount' => $faker->double(),
    ];
});
