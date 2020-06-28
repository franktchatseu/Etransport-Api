<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Planification\Agenda;
use Faker\Generator as Faker;

$factory->define(Agenda::class, function (Faker $faker) {
    return [
        'date_agenda' =>  $faker->date,
        'heure' => $faker->time,
        'activite' =>  $faker->sentence,
        'porteur' =>  $faker->name,
        'concerne' =>  $faker->text(),
        'lieu' =>  $faker->sentence,
    ];
});
