<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\IntentionMass;
use Faker\Generator as Faker;

$factory->define(IntentionMass::class, function (Faker $faker) {
    return [
        'ammount' => $faker->randomNumber($nbDigits=8),
        'request_date' => $faker->date(),
        'intention' => $faker->date(),
        'photo' => url('uploads/blogs/blogs.5edba4d14f1dc5.78797280.png'),
        'status' => $faker->randomElement(['REJECTED','PENDING','ACCEPTED']),

    ];
});
