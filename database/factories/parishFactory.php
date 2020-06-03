<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Person\parish as PersonParish;
use App\Models\Person\parish;
use Faker\Generator as Faker;

$factory->define(PersonParish::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'location' => $faker->statement(),
        'curé' => $faker->name,
        'creation_decision' => $faker->name,
        'mass_horary' => $faker->name,
        'confession_days' => $faker->name,
        'confession_horary' => $faker->name,
        'saint_patron_date' => $faker->name,
        'parish_structures' => $faker->name,
        'pastoral_services' => $faker->name,
        'number_of_groupes' => $faker->name,
        'number_of_ceb' => $faker->name,
        'number_of_post' => $faker->name,
        'patrimony' => $faker->paragraph(),
        'contact' => $faker->name,
        'seminarist_number' => $faker->name,

    ];
});
