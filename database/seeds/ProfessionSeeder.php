<?php

use Illuminate\Database\Seeder; 
use App\Models\Person\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    
        public function run(\Faker\Generator $faker)
    {
        factory(Profession::class, 21)->make()->each(function ($professions) use ($faker) {
            $professions->save();
        });
    }
    
}
