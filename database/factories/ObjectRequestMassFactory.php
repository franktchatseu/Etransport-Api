<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\ObjectRequestMass;
use Faker\Generator as Faker;

$factory->define(ObjectRequestMass::class, function (Faker $faker) {
    return [
        //
        'label' => $faker->sentence,
        'description' => $faker->sentence
    ];
});
