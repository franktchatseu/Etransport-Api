<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Actuality\Select;
use Faker\Generator as Faker;

$factory->define(Select::class, function (Faker $faker) {
    return [
        'value' =>  $faker->unique()->safari,
    ];
});
