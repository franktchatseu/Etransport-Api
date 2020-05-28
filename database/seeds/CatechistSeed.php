<?php

use Illuminate\Database\Seeder;
use App\Models\Person\Catechist;

class CatechistSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Catechist::class, 100)->make()->each(function($catechist) use ($faker) {
            $catechist->save();
        });
    }
}
