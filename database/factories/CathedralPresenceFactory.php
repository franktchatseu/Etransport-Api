<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\CathedralPresence;
use Faker\Generator as Faker;

$factory->define(CathedralPresence::class, function (Faker $faker) {
    return [
        'date_days' => $faker->date
    ];
});
