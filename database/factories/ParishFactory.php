<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\Parish;
use Faker\Generator as Faker;

$factory->define(Parish::class, function (Faker $faker) {
    return [
        'name' =>  $faker->text(20),
        'logo' =>  'upload/image.png',
        'name_priest' =>  $faker->text(20),
        'picture_priest' =>  'upload/image.png',
        'description' => $faker->text(),
        'decision_creation' => $faker->text(100),
        'Pattern_date' => $faker->date(),
        'nbr_of_structure' => $faker->numberBetween(1,100),
        'nbr_of_service' => $faker->numberBetween(1,100),
        'nbr_of_group' => $faker->numberBetween(1,100),
        'nbr_of_ceb' => $faker->numberBetween(1,100),
        'nbr_of_station' => $faker->numberBetween(1,100),
        'nbr_of_seminarist' => $faker->numberBetween(1,100),
    ];
});
          