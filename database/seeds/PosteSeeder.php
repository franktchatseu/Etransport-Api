<?php

use Illuminate\Database\Seeder;
use App\Models\Place\Poste;
use App\Models\Place\TypePoste;

class PosteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Poste::class, 100)->make()->each(function ($poste) use ($faker) {
             $type_postes= App\Models\Place\TypePoste::all();
             $poste->type_poste_id = $faker->randomElement($type_postes)->id;
            $poste->save();
        });
    }
}
