<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Association\Status;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->sentence,
    ];
});
