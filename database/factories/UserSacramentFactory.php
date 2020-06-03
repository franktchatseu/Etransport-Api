<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sacrament\UserSacrament;
use Faker\Generator as Faker;

$factory->define(UserSacrament::class, function (Faker $faker) {
    return [
        'request' => $faker->sentence,
        'isAspire' => $faker->boolean(),


    ];
});
