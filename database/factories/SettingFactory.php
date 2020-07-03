<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Setting;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        //
        'hour_payer' => $faker->times(),
        'angelus' => $faker->boolean(),
        'misericorde' => $faker->boolean(),
        'magnificat' => $faker->boolean(),
        'langue' => $faker->randomElement(['en','fr']),     

    ];
});
