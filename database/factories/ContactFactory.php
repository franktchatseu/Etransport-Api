<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'function' => $faker->name,
        'photo' => 'uploads/contact.png',
        'type' => $faker->name,
        // 'email_verified_at' => now(),
        'phones' => $faker->phoneNumber(),
        'PO_BOX'=>$faker->postcode,


    ];
});
