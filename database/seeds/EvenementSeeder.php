<?php

use App\Models\Association\Evenement;
use Illuminate\Database\Seeder;

class EvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        factory(Evenement::class, 21)->make()->each(function ($evenement) use ($faker) {
            $association = App\Models\Association\Association::all();
            $evenement->association_id = $faker->randomElement($association)->id;
            $evenement->save();
        });
    }
}
