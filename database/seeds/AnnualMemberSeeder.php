<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\AnnualMember;
use App\Models\Catechesis\QuarterTrimestre;

class AnnualMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run(\Faker\Generator $faker)
    {
        factory(AnnualMember::class, 100)->make()->each(function ($annualMember) use ($faker) {
            $quarter_trimestres = App\Models\Catechesis\QuarterTrimestre::all();
            $annualMember->quarter_trimestre_id = $faker->randomElement($quarter_trimestres)->id;
           $annualMember->save();
       });
    }
}
