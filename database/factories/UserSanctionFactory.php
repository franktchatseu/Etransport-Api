<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sanction\UserSanction;
use Faker\Generator as Faker;

$factory->define(UserSanction::class, function (Faker $faker) {
    return [
        'reason' => $faker->sentence,
    ];
});
