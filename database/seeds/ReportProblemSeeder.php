<?php

use Illuminate\Database\Seeder;
use App\Models\Request\ReportProblem;

class ReportProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(ReportProblem::class, 100)->make()->each(function ($reportProblem) use ($faker) {
            $utypes = App\Models\Person\Utype::all();
            $reportProblem->utype_id = $faker->randomElement($utypes)->id;
            $reportProblem->save();
        });
    }
}
