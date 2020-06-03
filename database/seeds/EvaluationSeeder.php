<?php

use App\Models\Catechesis\Evaluation;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Evaluation::class, 21)->make()->each(function ($evaluation) use ($faker) {
            $evaluation->save();
        });
    }
}
