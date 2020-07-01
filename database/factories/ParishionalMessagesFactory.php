<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Notification\ParishionalMessages;
use Faker\Generator as Faker;

$factory->define(ParishionalMessages::class, function (Faker $faker) {
    return [
        'title' => $faker->text(10),
        'type' => $faker->text(8),
        'description' => $faker->sentence(),
        'photo' => $faker->randomElement(['assets/images/logo-e-church.jpeg', 'assets/images/nonemessage.png', 'assets/images/font1.jpeg', 'assets/images/font2.png']),
        'effective_date' => $faker->date(),
    ];
});
