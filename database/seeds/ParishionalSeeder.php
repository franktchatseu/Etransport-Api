<?php

use App\Models\Person\Parishional;
use Illuminate\Database\Seeder;

class ParishionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Parishional::class, 100)->make()->each(function ($parishional) use ($faker) {
            $parishional->save();
        });
    }
}
