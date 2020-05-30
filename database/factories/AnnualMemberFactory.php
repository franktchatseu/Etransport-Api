<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\AnnualMember;
use Faker\Generator as Faker;

$factory->define(AnnualMember::class, function (Faker $faker) {
    return [
        'class' => $faker->sentence,
        'has_win' => $faker->boolean(),
    ];
});
