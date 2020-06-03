<?php

use Illuminate\Database\Seeder;
use App\Models\Catechesis\Catechesis;

class CatechesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Catechesis::class, 100)->make()->each(function($catechesis) use ($faker) {
            $catechesis->save();
        });
    }
}    
