<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Catechesis\Member;
use Faker\Generator as Faker;
use function GuzzleHttp\json_encode;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'regnum' => $faker->unique()->sentence,
        'adhesion_date' => $faker->date,
        'is_finish' => $faker->boolean(),
        'has_win' => $faker->boolean(),
        'files' => json_encode(['https://picsum.photos/200/300']),
        'status' => $faker->randomElement(['REJECTED','PENDING','ACCEPTED']),
    ];
});
