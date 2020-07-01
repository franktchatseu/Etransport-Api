<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Finance\InputUUtype;
use Faker\Generator as Faker;

$factory->define(InputUUtype::class, function (Faker $faker) {
    return [
        'amount' => $faker->numberBetween(10000,100000),
        'date' => $faker->date,
        'city' => $faker->sentence,
        'country' => $faker->sentence,
        'pseudo' => $faker->sentence,
        'status' => $faker->boolean(),
        'bill_url' => url('uploads/blogs/blogs.5edba4d14f1dc5.78797280.png'),
        'transaction_id' => $faker->numberBetween(1,100),
        'provenance' => $faker->sentence
    ];
});
