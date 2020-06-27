<?php

use App\Models\Publicity\Publicity;
use Illuminate\Database\Seeder;

class PublicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Publicity::class, 20)->make()->each(function ($publicity) use ($faker) {
            $publicity->save();
        });
    }
}
