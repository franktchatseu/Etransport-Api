<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\ObjectMakingAppointment;
use Faker\Generator as Faker;

$factory->define(ObjectMakingAppointment::class, function (Faker $faker) {
    return [
        //
        'label' => $faker->sentence,
        'description' => $faker->sentence,
        'type' => $faker->randomElement(['MASS', 'APPOINTMENT', 'MASS_ASKING'])
    ];
});