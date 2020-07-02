<?php

use App\Models\Setting\Parish;
use Illuminate\Database\Seeder;

class ParishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Parish::class, 10)->make()->each(function ($parish) use ($faker) {
            $parish->save();
        });
    }
}
