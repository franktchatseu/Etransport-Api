<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Association\Evenement;
use Faker\Generator as Faker;

$factory->define(Evenement::class, function (Faker $faker) {
    return [
        'raison' => $faker->sentence,
        'description' => $faker->sentence,
        'start_event_date' => $faker->date,
        'end_event_date' => $faker->date,
        'start_hour' => $faker->time,
        'end_hour' => $faker->time,
    ];
});
