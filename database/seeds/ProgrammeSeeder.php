<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\Programme;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Programme::class, 100)->make()->each(function ($programme) use ($faker) {
            $programme->save();
        });
    }
}
