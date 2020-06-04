<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Setting\Photo;
use Faker\Generator as Faker;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'picture' =>  $faker->imageUrl('https://www.paroissesaintjeandedeido.org/images/IMAGES_PSJD/PSJD/ParoisseSaintJeanDeido.jpg'),
        'description' => $faker->sentence,
    ];
});

