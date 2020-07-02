<?php

use App\Models\Finance\PatternDonation;
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
        factory(PatternDonation::class, 5)->make()->each(function ($pattern) use ($faker) {
            $pattern->save();
        });
    }
}
