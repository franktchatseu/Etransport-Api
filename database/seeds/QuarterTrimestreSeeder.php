<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\QuarterTrimestre;
use App\Models\Catechesis\Quarter;
use App\Models\Catechesis\Trimestre;

class QuarterTrimestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(QuarterTrimestre::class, 100)->make()->each(function ($quarterTrimestre) use ($faker) {
            $quarters = App\Models\Catechesis\Quarter::all();
            $trimestres = App\Models\Catechesis\Trimestre::all();
            $quarterTrimestre->quarter_id = $faker->randomElement($quarters)->id;
            $quarterTrimestre->trimestre_id = $faker->randomElement($trimestres)->id;
            $quarterTrimestre->save();
        });
    }
}
