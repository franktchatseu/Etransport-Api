<?php

use Illuminate\Database\Seeder;

class patterndonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(PatternDonation::class, 10)->make()->each(function ($pattern) use ($faker) {
            $pattern->save();
        });
    }
}
