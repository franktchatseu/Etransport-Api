<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Association\MemberAssociation;
use Faker\Generator as Faker;

$factory->define(MemberAssociation::class, function (Faker $faker) {
    return [
        'raisonAdhesion' => $faker->sentence,
        'date_adhesion' => $faker->date,
        'name' => 'Frank',
        'telephone' => '696812610',
        'status' => $faker->randomElement(['MEMBER','SECRETAIRE','CENSEUR','PRESIDENT','VICE_PRESIDENT']),
    ];
});
