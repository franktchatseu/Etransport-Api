<?php

use App\Models\Catechesis\Evaluation;
use Illuminate\Database\Seeder;
use App\Models\Catechesis\Trimestre;
use App\Models\Catechesis\AnnualMember;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Evaluation::class, 100)->make()->each(function ($evaluation) use ($faker) {
            $trimestres = App\Models\Catechesis\Trimestre::all();
            $evaluation->trimestres_id = $faker->randomElement($trimestres)->id;
            $annualMembers = App\Models\Catechesis\AnnualMember::all();
            $evaluation->annual_member_id = $faker->randomElement($annualMembers)->id;
           $evaluation->save();
       });
    }
}
