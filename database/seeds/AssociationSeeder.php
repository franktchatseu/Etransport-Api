<?php

use App\Models\Association\Association;
use Illuminate\Database\Seeder;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 
    public function run(\Faker\Generator $faker)
    {    
        factory(Association::class, 100)->make()->each(function ($association) use ($faker) {
            $types = App\Models\Association\TypeAssociation::all();
            $parish = App\Models\Setting\Parish::all();
            $user = App\Models\Person\User::all();
            $association->type_id = $faker->randomElement($types)->id;
           
            $association->parish_id = $faker->randomElement($parish)->id;
           
            $association->user_id = $faker->randomElement($user)->id;
            $association->save();
        });
    }
}
