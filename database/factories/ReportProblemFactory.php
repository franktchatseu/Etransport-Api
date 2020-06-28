<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Request\ReportProblem;
use Faker\Generator as Faker;
$factory->define(ReportProblem::class, function (Faker $faker) {
    return [
        'nature' => $faker->sentence(),
        'concerne' => $faker->sentence(),
        'details' => $faker->paragraph(),
        'image' => $faker->imageUrl('https://www.paroissesaintjeandedeido.org/images/IMAGES_PSJD/PSJD/ParoisseSaintJeanDeido.jpg'),
    ];
});
