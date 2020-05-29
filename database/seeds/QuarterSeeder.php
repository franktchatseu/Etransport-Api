<?php

use App\Models\Catechesis\Quarter;
use Illuminate\Database\Seeder;

class QuarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Quarter::class, 21)->make()->each(function ($quarter) use ($faker) {
            $quarter->save();
        });
    }
}
