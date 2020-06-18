<?php

use App\Models\Association\Statut;
use Illuminate\Database\Seeder;

class StatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Statut::class, 21)->make()->each(function ($statut) use ($faker) {
            $statut->save();
        });
    }
}
