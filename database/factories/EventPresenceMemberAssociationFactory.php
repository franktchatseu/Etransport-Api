<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Association\EventPresenceMemberAssociation;
use Faker\Generator as Faker;

$factory->define(EventPresenceMemberAssociation::class, function (Faker $faker) {
    return [
        'isPresence' => $faker->boolean(),
    ];
});
