<?php

use App\Models\Place\TypePlace;
use Illuminate\Database\Seeder;

class PlaceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(TypePlace::class, 10)->make()->each(function ($placetype) use ($faker) {
            $placetype->save();
        });
    }
}
