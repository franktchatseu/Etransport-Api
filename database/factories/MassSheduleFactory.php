<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\MassShedule;
use Faker\Generator as Faker;

$factory->define(MassShedule::class, function (Faker $faker) {
    return [
        'context' => $faker->sentence,
        'description' => $faker->sentence,
        'day' => $faker->sentence,
        'end_date' => $faker->date,
        'start_date' => $faker->date
    
    ];
});
