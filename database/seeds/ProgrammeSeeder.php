<?php

use Illuminate\Database\Seeder;
use App\Models\Setting\Programme;
use App\Models\Setting\Parish;
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
            $parish = Parish::all();
            $programme->parish_id = $faker->randomElement($parish)->id;
            $programme->save();
        });
    }
}
