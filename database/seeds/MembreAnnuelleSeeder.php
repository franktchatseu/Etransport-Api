<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\MembreAnnuelle;


class MembreAnnuelleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run(\Faker\Generator $faker)
    {
        factory(MembreAnnuelle::class, 100)->make()->each(function ($membreAnnuelle) use ($faker) {
            $membreAnnuelle->save();
        });
    }
}
