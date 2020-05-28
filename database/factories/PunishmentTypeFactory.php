<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sanction\PunishmentType;
use Faker\Generator as Faker;

$factory->define(PunishmentType::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->text(50),
        'description' => $faker->sentence,
    ];
});
