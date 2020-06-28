<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\AnointingSick;
use Faker\Generator as Faker;

$factory->define(AnointingSick::class, function (Faker $faker) {
    return [
        'assisted_person' => $faker->name,
        'age' => $faker->numberBetween(0,120),
        'gender' => $faker->randomElement(['F', 'M']),
        'quater' => $faker->streetName(),
        'disease_nature' => $faker->sentence,
        'is_baptized' => $faker->boolean(),
        'avatar' => url('uploads/blogs/blogs.5edba4d14f1dc5.78797280.png'),
        'request_date' => $faker->date(),
        'comment' => $faker->text,
        'status' => $faker->randomElement(['REJECTED','PENDING','ACCEPTED']),

    ];
});
