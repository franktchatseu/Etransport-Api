<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Request\SettingRequest;
use Faker\Generator as Faker;

$factory->define(SettingRequest::class, function (Faker $faker) {
    return [
        'slug' => $faker->unique()->sentence(),
        'goodToKnow' => $faker->paragraph(),
        'amount' => $faker->numberBetween(5000, 25000),
    ];
});
