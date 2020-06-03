<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\Tarif;
use Faker\Generator as Faker;

$factory->define(Tarif::class, function (Faker $faker) {
    return [
       'name' =>  $faker->text(20),
       'description' => $faker->text(100),
       'price' => $faker->numberBetween(1,1000000),
    ];
});
