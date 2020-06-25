<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\Input;
use Faker\Generator as Faker;

$factory->define(Input::class, function (Faker $faker) {
    return [
        'amount' =>  $faker->randomNumber($nbDigits=8),
        'description' => $faker->text,
        'reason' => $faker->text(100),
        'start_date' => $faker->date,
        'end_date' => $faker->date,
    ];
});
