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
            $association->type_id = $faker->randomElement($types)->id;
            $association->save();
        });
    }
}
