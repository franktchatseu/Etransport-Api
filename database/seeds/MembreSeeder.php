<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\Membre;

class MembreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Membre::class, 100)->make()->each(function ($membre) use ($faker) {
            $membre->save();
        });
    }
}
