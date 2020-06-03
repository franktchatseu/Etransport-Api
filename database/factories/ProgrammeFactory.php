<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Programme;
use Faker\Generator as Faker;

$factory->define(Programme::class, function (Faker $faker) {
    return [
        'duree' => $faker->numberBetween(1,100),
        'jour' => $faker->randomElement(['LUNDI','MARDI','MERCREDI','JEUDI','VENDREDI','SAMEDI','DIMANCHE']),
        'heure_debut' => $faker->time,
        'type' => $faker->randomElement(['REGULIER','IRREGULIER']),
        'date_planifiee' => $faker->date,
    ];
});
