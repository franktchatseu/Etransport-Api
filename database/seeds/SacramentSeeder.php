<?php

use Illuminate\Database\Seeder;
use App\Models\Person\Sacrament;

class SacramentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Sacrament::class, 21)->make()->each(function ($sacrament) use ($faker) {
            $sacrament->save();
        });
    }
}
