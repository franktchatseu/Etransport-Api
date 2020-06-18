<?php

use Illuminate\Database\Seeder;
use App\Models\Place\TypePoste;

class TypePosteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(TypePoste::class, 100)->make()->each(function ($typePoste) use ($faker) {
            $typePoste->save();
        });
    }
}
