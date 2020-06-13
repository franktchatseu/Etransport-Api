<?php

use App\Models\Catechesis\Trimestre;
use Illuminate\Database\Seeder;


class TrimestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Trimestre::class, 100)->make()->each(function ($trimestre) use ($faker) {
            $trimestre->save();
        });
    }
}
