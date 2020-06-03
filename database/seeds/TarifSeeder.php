<?php

use Illuminate\Database\Seeder;
use App\Models\Finance\Tarif;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //
        factory(Tarif::class, 100)->make()->each(function ($tarif) use ($faker) {
            $tarif->save();
        });
        
    }
}
