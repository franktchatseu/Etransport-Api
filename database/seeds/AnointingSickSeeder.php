<?php

use Illuminate\Database\Seeder;
use App\Models\Request\AnointingSick;

class AnointingSickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(AnointingSick::class, 100)->make()->each(function ($anoitingSick) use ($faker) {
            $anoitingSick->save();
        });
    }
}
