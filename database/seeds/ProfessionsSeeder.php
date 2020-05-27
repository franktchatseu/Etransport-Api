<?php

use Illuminate\Database\Seeder; 
use App\Models\Person\Professions;

class ProfessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    
        public function run(\Faker\Generator $faker)
    {
        factory(Professions::class, 21)->make()->each(function ($professions) use ($faker) {
            $professions->save();
        });
    }
    
}
