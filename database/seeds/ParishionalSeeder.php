<?php

use App\Models\Person\Parishional;
use Illuminate\Database\Seeder;

class ParishionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Parishional::class, 100)->make()->each(function ($parishional) use ($faker) {
            $users = App\Models\Person\User::all();
            $parishional->user_id = $faker->randomElement($users)->id;
            $parishional->save();
        });
    }
}
