<?php

use App\Models\Person\Priest;
use Illuminate\Database\Seeder;

class PriestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {    
        factory(Priest::class, 10)->make()->each(function ($priest) use ($faker) {
            $users = App\Models\Person\User::all();
            $priest->user_id = $faker->randomElement($users)->id;
            $priest->save();
        });
    }
}
