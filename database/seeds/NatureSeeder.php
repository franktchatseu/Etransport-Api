<?php

use Illuminate\Database\Seeder;
use App\Models\Finance\Nature;

class NatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Nature::class, 50)->make()->each(function ($nature) use ($faker) {
            $nature->save();
        });
    }
}
